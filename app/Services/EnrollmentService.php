<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Enrollment\EnrollmentsResource;
use App\Http\Resources\Enrollment\ListSchoolAdminResource;
use App\Http\Resources\User\UsersResource;
use App\Mapper\PaginationMapper;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use App\Repositories\EnrollmentRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class EnrollmentService
{
    /**
     * Undocumented function
     *
     * @param EnrollmentRepository $countryRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected EnrollmentRepository $enrollmentRepository,protected UserRepository $userRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData){}

    /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = [])
    {
        $enrollments = $this->enrollmentRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
                EnrollmentsResource::collection($enrollments),
            __('admin.enrollments.list'),$enrollments instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$enrollments):[]
        );
    }
     /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getStaff(array $options = [])
    {
        $enrollments = $this->userRepository->getCanEnrollment($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             $enrollments,
            __('admin.users.list')
        );
    }

      /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getCanSchoolOwner(array $options = [])
    {
        $canSchoolOwner = $this->userRepository->getCanSchoolOwner($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             $canSchoolOwner,
            __('admin.users.list')
        );
    }
       /**
        * Show function
        *
        * @param int $id
        * @return void
        */
       public function show(int $id)
       {
           $country = $this->enrollmentRepository->show($id);

           return $this->returnData->create(
               [],
               Response::HTTP_OK,
               new EnrollmentsResource($country),
               [__('admin.enrollments.show')],
           );
       }

       /**
        * Update Enrollment function
        *
        * @param array $data
        * @param integer $id
        * @return void
        */
       public function update(array $data, int $id)
       {
           try {

            $enrollment = $this->enrollmentRepository->find($id);

            $oldUser=User::findOrfail($enrollment->user_id);

            $oldUser->roles()->detach(Role::where('id',$enrollment->role_id)->pluck('id')->toArray());

            $user=$this->userRepository->update(['school_id'=>$data['school_id']],$data['user_id']);

            $newUser=User::findOrfail($data['user_id']);

            $newUser->roles()->attach(Role::where('id',$data['role_id'])->pluck('id')->toArray());


            $enrollment = $this->enrollmentRepository->update($data,$id);

                    return $this->returnData->create(
                       [],
                       Response::HTTP_OK,
                       new EnrollmentsResource($enrollment),
                       [__('admin.enrollments.update')]
                   );
           }catch (Exception $excption) {

               logger(
                   [
                       'error' => $excption->getMessage(),
                       'code' => $excption->getCode(),
                       'file' => $excption->getFile(),
                       'line' => $excption->getLine(),
                   ]
               );
           }
           return $this->returnData->create(
               [__('admin.enrollments.not_update')],
               Response::HTTP_UNPROCESSABLE_ENTITY,
               []
           );
       }


       /**
     * Create function
     *
     * @param array $data
     * @return array
     */
    public function removeSchoolAdmin(array $data)
    {
        DB::beginTransaction();

        try {

            $schoolOwner=School::where('id',$data['school_id'])->where('admin_id',$data['user_id'])->first();

            if($schoolOwner){
                    return $this->returnData->create(
                        [__('admin.enrollments.remove_school_admin')],
                        Response::HTTP_UNPROCESSABLE_ENTITY,
                        [],
                        []
                );
            }

            $user=User::findOrfail($data['user_id']);
            $user->update(['school_id' => $data['school_id'],'is_school_admin'=>0]);

            //Attach Role School Admin To User
            $role=Role::where('code','schooladmin')->firstOrfail();
            $user->roles()->where('code','schooladmin')->detach([$role->id]);


            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    [],
                    [__('admin.enrollments.remove')]
                );

        } catch (Exception $excption) {
            logger(
                [
                    'error'=>$excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.enrollments.not_remove')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }


    /**
     * Create function
     *
     * @param array $data
     * @return array
     */
    public function addSchoolAdmin(array $data)
    {
        DB::beginTransaction();

        try {
            $user=User::findOrfail($data['user_id']);
            $user->update(['school_id' => $data['school_id'],'is_school_admin'=>1]);

            //Attach Role School Admin To User
            $role=Role::where('code','schooladmin')->firstOrfail();
            $role->users()->attach($data['user_id']);


            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    [],
                    [__('admin.enrollments.create')]
                );

        }catch (Exception $excption) {
            logger(
                [
                    'error'=>$excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.enrollments.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }


    /**
     * Create function
     *
     * @param array $data
     * @return array
     */
    public function listSchoolAdmins(array $option)
    {

        $schoolAdmins = $this->userRepository->listSchoolAdmins($option);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                    ListSchoolAdminResource::collection($schoolAdmins),
                __('admin.schooladmins.list'),$schoolAdmins instanceof \Illuminate\Pagination\LengthAwarePaginator ?
                $this->paginationMapper->metaPagination($option,$schoolAdmins):[]
            );
    }
    /**
     * Create function
     *
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {

            $user=User::findOrfail($data['user_id']);

            $user->update(['school_id' => $data['school_id']]);

            $user->roles()->attach(Role::where('id',$data['role_id'])->pluck('id')->toArray());


            foreach($data['class_id'] as $class){
                $data['class_id']=$class;
                $enrollment = $this->enrollmentRepository->updateOrCreate($data,$data);
            }

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new EnrollmentsResource($enrollment),
                    [__('admin.enrollments.create')]
                );

        } catch (Exception $excption) {
            logger(
                [
                    'error'=>$excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.enrollments.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
    /**
     * Delete function
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id)
    {
        try {
            $this->enrollmentRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.enrollments.delete')]
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
                [__('admin.enrollments.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

}
