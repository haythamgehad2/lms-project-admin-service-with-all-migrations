<?php
namespace App\Services;
use App\Enums\RoleTypeEnum;
use App\Enums\UserStatusEnum;
use App\Mapper\PaginationMapper;
use App\Helpers\ReturnData;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UsersResource;
use App\Jobs\SendVerifyEmail;
use App\Mapper\UserMapper;
use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use App\Repositories\SettingRepository;
use App\Repositories\UserCreditRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelReader;
use function trans;
class UserService
{
    /**
     * @var PaginationMapper
     */
    protected $paginationMapper;

    /**
     * @var ReturnData
     */
    protected $returnData;

    /**
     * @var UserMapper
     */
    protected $userMapper;


    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var SettingRepository
     */
    protected $settingRepository;


    public function __construct(
        PaginationMapper $paginationMapper,
        ReturnData $returnData,
        UserMapper $userMapper,
        UserRepository $userRepository,
        SettingRepository $settingRepository,
        private UserCreditRepository $userCreditRepository
    ) {
        $this->paginationMapper = $paginationMapper;
        $this->returnData = $returnData;
        $this->userMapper = $userMapper;
        $this->userRepository = $userRepository;
        $this->settingRepository = $settingRepository;
    }

    /**
     * getAll function
     *
     * @param array $options
     * @return void
     */
    public function getAll(array $options = [])
    {

        $users = $this->userRepository->getAll($options,
            isset($options['name']) ? $options['name'] : null,
            isset($options['status']) ? $options['status'] : null);


        return $this->returnData->create(
            [],
             Response::HTTP_OK,
             UsersResource::collection($users),
            trans('group.users_list'),
            $users instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$users):[]
        );
    }

    /**
     * login function
     *
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): array
    {

        try {

            $user = $this->userRepository->findByEmail($credentials['email']);
            $maxAttempts =$this->settingRepository->findByKey('login_attemps');

            if($user){

                // if user reachs max attampts defined in system
                if($user->failed_attempts == intval($maxAttempts->value)){
                    $returnData = $this->returnData->create(
                        [__('auth.login_block')],
                        Response::HTTP_UNAUTHORIZED,
                        []
                    );
                    $user->status = User::BLOCKED_STATUS;
                    $user->save();
                    return $returnData;
                }

                //if user is blocked
                if($user->status == User::BLOCKED_STATUS)
                    return $this->returnData->create(
                        [__('auth.login_block')],
                        Response::HTTP_UNAUTHORIZED,
                        []
                    );


                //if user account if deactivated
                if($user->status == User::DEACTIVATED_STATUS)
                    return $this->returnData->create(
                        [__('auth.login_deactivated')],
                        Response::HTTP_UNAUTHORIZED,
                        []
                    );

                //if user account if unverified
                if($user->status == User::UNVERIFIED_STATUS)
                    return $this->returnData->create(
                        [__('auth.login_verify')],
                        Response::HTTP_UNAUTHORIZED,
                        []
                    );
            }

            if (!$token = Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])) {

                if($user){
                    $user->failed_attempts = intval($user->failed_attempts) + 1;
                    $user->last_attempt = Carbon::now()->format('Y-m-d');
                    $user->save();
                }
                return $this->returnData->create(
                    [__('auth.login_not_exists')],
                    Response::HTTP_UNAUTHORIZED,
                    []
                );
            }

            $authUser = Auth::user();

            $user->failed_attempts = 0;
            $user->save();

            $permissions = $this->getUserPermissions($authUser);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [
                    'user' =>   new UserResource($user->load("userCredit")),
                    //to do add permissions with token
                    //get all permission from all roles
                    //convert to array of strings
                    //inject in token
                    'token_data' => $authUser->createToken("API TOKEN",$permissions)->plainTextToken
                ],
                [trans('auth.login_success')]
            );
        } catch (Exception $exception) {
            logger([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
            return $this->returnData->create([trans('auth.login_failed')], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    /**
     * getAuthenticatedUser function
     *
     * @return array
     */
    public function tmpExcelUserImport()
    {
        try {

            if (auth()->check()) {

            $path=Storage::disk('public')->path('Jeel_Tep_Import_User.xlsx');

            if($path){
                $headers = [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ];

                return response()->download($path, 'Jeel_Tep_Import_User.xlsx', $headers);

            }
        }
        } catch (Exception $exception) {
            logger(
                [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );

            return $this->returnData->create(
                [trans('auth.user_not_found')],
                Response::HTTP_UNAUTHORIZED,
                []
            );
        }
    }


    /**
     * Undocumented function
     *
     * @param [type] $file
     * @return string
     */
    private function fileExcelUser($file):string
    {
        $target = $file->move(storage_path('app/importUser'), $file->getClientOriginalName());
        return $target->getPath() . DIRECTORY_SEPARATOR . $target->getFileName();
    }
    /**
     * getAuthenticatedUser function
     *
     * @return array
     */
    public function importExcelUser(array $data):array
    {

        DB::beginTransaction();
        try{

         $path=$this->fileExcelUser($data['file']);

            $reader = SimpleExcelReader::create($path);
            $rows = $reader->getRows();

            $errorRecords = [];


                foreach ($rows as $index => $row) {

                    if ($index === 0) { // skip header row
                        continue;
                    }

                $validator=$this->excelValidation($row);

                if ($validator->fails()) {
                    $errorRecords[] = array_merge($row, ['errors' =>  $validator->errors()->all()]);
                    continue;
                }

                    $user = $this->userRepository->create([
                        'first_name'=>$row['FirstName'],
                        'last_name'=>$row['LastName'],
                        'name'=> $row['FirstName'].' '.$row['LastName'],
                        'mobile'=>$row['Mobile'],
                        'email'=>$row['Email'],
                        'password'=>$row['Password'],
                        'lang_id'=>Language::EN_ID
                    ]);


                   $role= Role::where('code','like',"%{$row['ROLE']}%")->first();
                   $user->roles()->attach([$role->id]);

                    if($row['ROLE'] == 'student'){
                        $user->status = UserStatusEnum::UNVERIFIED_STATUS;
                        $user->save();
                    }

                }

                DB::commit();

                if(is_array($errorRecords) && count($errorRecords) > 0){
                    return $this->returnData->create(
                        $errorRecords,
                        Response::HTTP_OK,
                        [],
                        [trans('excel.export_with_error')]
                    );
                }else{

                    return $this->returnData->create(
                        [],
                        Response::HTTP_OK,
                        [],
                        [trans('excel.export_success')]
                    );
                }
        }catch (Exception $exception) {
            logger(
                [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );
            DB::rollback();

            return $this->returnData->create(
                [trans('auth.user_not_found')],
                Response::HTTP_UNAUTHORIZED,
                []
            );
        }
    }

    /**
     * Excel Valdation Data function
     *
     * @param [type] $row
     * @return object
     */
    private function excelValidation($row):object
    {

        $validator = Validator::make($row, [
            'FirstName' => 'required',
            'LastName' => 'required',
            'Mobile' => 'required',
            'Email' => 'required|email|unique:users',
            'image' => 'nullable|image|max:2048',
            'role' => 'nullable|in:student,supervisor,school_admin,teatcher',
            'Password' => 'required|min:6',
        ]);
        return $validator;
    }
    /**
     * getUserPermissions function
     *
     * @param User $user
     * @return array
     */
    public function getUserPermissions(User $user): array
    {
        $data = [];
        if(count($user->roles) > 0){
            foreach($user->roles as $role){
                $data = array_merge($data,$role->permissions->pluck('code')->toArray());
            }
        }

        return $data;
    }

    /**
     * authCheck function
     *
     * @return array
     */
    public function authCheck(): array
    {
        try {
            if (auth()->check()) {
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    [],
                    ['OK']
                );
            }
        } catch (Exception $exception) {
            logger(
                [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );
        }
        return $this->returnData->create(
            [trans('auth.unauthorized')],
            Response::HTTP_UNAUTHORIZED,
            []
        );
    }

    /**
     * refresh function
     *
     * @return array
     */
    public function refresh(): array
    {
        try {
            if (auth()->check()) {
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    [
                        'token_data' => $this->getAuthTokenData(auth()->refresh()),
                    ],
                    [trans('auth.token_refresh_success')]
                );
            }
        } catch (Exception $exception) {
            logger(
                [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );
        }
        return $this->returnData->create(
            [trans('auth.token_refresh_fail')],
            Response::HTTP_UNAUTHORIZED,
            []
        );
    }

    /**
     * getAuthenticatedUser function
     *
     * @return array
     */
    public function getAuthenticatedUser(): array
    {
        try {
            if (auth()->check()) {
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    [
                        'user' =>  new UserResource(auth()->user()->load("userCredit"))
                    ],
                    [trans('auth.user_fetched_success')]
                );
            }
        } catch (Exception $exception) {
            logger(
                [
                    'error' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );

            return $this->returnData->create(
                [trans('auth.user_not_found')],
                Response::HTTP_UNAUTHORIZED,
                []
            );
        }
    }

    /**
     * VerifyUserEmail function
     *
     * @param User $user
     * @param integer $code
     * @return Array
     */
    public function VerifyUserEmail(User $user, int $code): Array
    {
        try {

            if($user->verification_code == $code){
                $timeStamp = Carbon::create($user->verification_sent_at);
                if($timeStamp->diffInMinutes(Carbon::now()) > 30)
                    return $this->returnData->create(
                        [__('the code is expired')],
                        Response::HTTP_UNAUTHORIZED,
                        [],
                        []
                    );

                $user->status = User::ACTIVE_STATUS;
                $user->save();

                return $this->returnData->create(
                    [__('success')],
                    Response::HTTP_OK,
                    [],
                    []
                );
            }

            return $this->returnData->create(
                [__('unvalid code')],
                Response::HTTP_UNAUTHORIZED,
                [],
                []
            );
        } catch (Exception $e) {
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

        }
    }
    /**
     * sendVerifyEmail function
     *
     * @param string $email
     * @return array
     */
    public function sendVerifyEmail(string $email): array
    {
        try {

            $user = $this->userRepository->findByEmail($email);
            if ($user) {
                if($user->status == User::UNVERIFIED_STATUS){
                    // $this->createAndSendVerifyCode($user);
                }
                elseif($user->status == User::BLOCKED_STATUS)
                return $this->returnData->create(
                    __('you can\'t proform this action, your account is blocked'),
                    Response::HTTP_UNAUTHORIZED,
                    [],
                    []
                );
                elseif($user->status == User::ACTIVE_STATUS)
                return $this->returnData->create(
                    [__('your account is already verified')],
                    Response::HTTP_UNAUTHORIZED,
                    [],
                    []
                );
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK
                );
            }
        } catch (Exception $e) {
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

        }

        return $this->returnData->create(
            __('send verify email failed'),
            Response::HTTP_UNPROCESSABLE_ENTITY,
            [],
            []
        );
    }
    /**
     * Send Verfiy Code To Email function
     *
     * @param User $user
     * @return void
     */
    private function createAndSendVerifyCode(User $user): void
    {
        $user->verification_code = rand(1000,9999);
        $user->verification_sent_at = Carbon::now();
        $user->save();

        SendVerifyEmail::dispatch($user);
    }

    /**
     * Register Function
     *
     * @param [type] $userData
     * @return array
     */
    public function register($userData): array
    {
            DB::beginTransaction();
        try{
            $userData['name'] = $userData['first_name'].' '.$userData['last_name'];

            $userData['lang_id']=Language::EN_ID;

            $user=User::create($userData);
            // $user = $this->userRepository->create($userData);

            if(isset($userData['roles'])){


            $user->roles()->attach($userData['roles']);

                if(!array_search(RoleTypeEnum::STUDENT_ROLE_ID,$userData['roles'])){

                    $user->status = UserStatusEnum::UNVERIFIED_STATUS;
                    $user->save();
                    // $this->createAndSendVerifyCode($user);
                }
            }

                if(\Request::hasFile('image'))
                    $user->saveFiles($userData['image']);



            $this->userCreditRepository->createByUser($user);
            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new UserResource($user->load("userCredit")),
                    [trans('user.created_success')]
                );

        }catch(Exception $e){
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            DB::rollBack();

            return $this->returnData->create(
                [trans('user.created_fail')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [],
                []
            );
        }

    }

    /**
     * isDomainExist function
     *
     * @param string $mail
     * @return integer|null
     */
    public function isDomainExist(string $mail): ?int
    {
        try {
            $explodeMail = explode('@', $mail);
        } catch (Exception $e) {
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }

        return null;
    }

    /**
     * getUserById function
     *
     * @param integer $id
     * @return array
     */
    public function getUserById(int $id): array
    {
        try {
            $user = $this->userRepository->find($id)->load("studentActionHistory.rewardAction", "userCredit");

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new UserResource($user),
                    [trans('user.return_success')]
                );
            return $this->returnData->create(
                [],
                Response::HTTP_NOT_FOUND,
                [trans('auth.user_not_found')]
            );
        } catch (Exception $e) {
            logger([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return $this->returnData->create(
                [trans('user.created_fail')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [],
                []
            );
        }
    }

    /**
     * update function
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        DB::beginTransaction();
        try {
            $data['name'] = $data['first_name'] . ' ' . $data['last_name'];

            if(!isset($data['password'])){
                 $data = Arr::except($data,['password']);
            }

            $user = $this->userRepository->update($data,$id);

            if(\Request::hasFile('image'))
                $user->updateFile($data['image']);

            if(isset($data['roles'])){
            $user->roles()->sync($data['roles']);
            }

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new UserResource($user->load("userCredit")),
                    [trans('user.user_has_been_updated_successfully')]
                );

        } catch (Exception $e) {
            logger([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'stack-trace' => $e->getTraceAsString()
            ]);

            DB::rollBack();

            return $this->returnData->create(
                [
                    trans('user.user_has_not_been_updated'),
                    $e->getMessage()
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [],
                []
            );
        }
    }


    /**
     * activateUser function
     *
     * @param integer $id
     * @return array
     */
    public function activateUser(int $id): array
    {
        try {
            $user = $this->userRepository->find($id);
            if ($this->userRepository->update(['is_active' => 1], $id)) {
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    $this->userMapper->map($user->fresh()),
                    [trans('user.user_has_been_activated_successfully')]
                );
            }
        } catch (Exception $e) {
            logger([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'stack-trace' => $e->getTraceAsString()
            ]);
        }

        return $this->returnData->create(
            [trans('user.user_has_not_been_activated')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            [],
            []
        );
    }


    /**
     * changePassword function
     *
     * @param array $data
     * @return void
     */
    public function changePassword(array $data)
    {
        try {
            $user = auth()->user();
            if($this->checkCorrectPassword($user, $data['old_password'])) {
                if($this->userRepository->update(['password' => Hash::make($data['new_password'])], $user->id)) {
                    return $this->returnData->create(
                        [],
                        Response::HTTP_OK,
                        [],
                        [trans('user.password_has_been_changed_successfully')]
                    );
                }
            }
        } catch (Exception $e) {
            logger([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'stack-trace' => $e->getTraceAsString()
            ]);
        }

        return $this->returnData->create(
            [trans('user.password_has_not_been_changed')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            [],
            []
        );
    }

    /**
     * checkCorrectPassword function
     *
     * @param User $user
     * @param string $password
     * @return boolean
     */
    public function checkCorrectPassword(User $user, string $password): bool
    {
        if (Hash::check($password, $user->password)) {
            return true;
        }

        return false;
    }

    /**
     * delete function
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        try {
            if(!$this->checkUser($id)) {
                return $this->returnData->create(
                    [trans('user.you_can_not_delete_this_user')],
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    []
                );
            }
            $this->userRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [trans('user.user_has_been_deleted')]
            );
        } catch (Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [trans('user.user_has_not_been_deleted')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
     * checkUser function
     *
     * @param integer $id
     * @return void
     */
    public function checkUser(int $id) {
        $user = $this->userRepository->find($id);
        $authUser = Auth::user();


        if($user->account_id == $authUser->account_id) {
            return true;
        }

        return false;
    }
}
