<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\Student\StudentClassResource;
use App\Mapper\PaginationMapper;
use App\Models\Role;
use App\Models\User;
use App\Repositories\StudentClassRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class StudentClassService
{
    /**
     * Undocumented function
     *
     * @param StudentClassRepository $studentRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected StudentClassRepository $studentRepository,protected UserRepository $userRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData){}

    /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = [])
    {
        $students = $this->studentRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
                StudentClassResource::collection($students),
            __('admin.student_enrollments.list'),
            $students instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$students):[]
        );
    }
     /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getStudents(array $options = [])
    {
        $enrollments = $this->userRepository->getCanStudentEnroll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             $enrollments,
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
           $student = $this->studentRepository->show($id);

           return $this->returnData->create(
               [],
               Response::HTTP_OK,
               new StudentClassResource($student),
               [__('admin.student_enrollments.show')],
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

            $studentData = $this->studentRepository->find($id);

            $user=User::findOrfail($studentData->user_id);

            $user->roles()->detach(Role::where('code','student')->pluck('id')->toArray());

            $student = $this->studentRepository->update($data,$id);

            $newUser=User::findOrfail($data['user_id']);

            $newUser->roles()->attach(Role::where('code','student')->pluck('id')->toArray());


                    return $this->returnData->create(
                       [],
                       Response::HTTP_OK,
                       new StudentClassResource($student),
                       [__('admin.student_enrollments.update')]
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
               [__('admin.student_enrollments.not_update')],
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
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $user=User::findOrfail($data['user_id']);

            if (!$user->userCredit){
                $user->userCredit()->create();
            }
            
            $user->update(['school_id' => $data['school_id']]);

            $user->roles()->attach(Role::where('code','student')->pluck('id')->toArray());

            $student = $this->studentRepository->updateOrCreate($data,$data);

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new StudentClassResource($student),
                    [__('admin.student_enrollments.create')]
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
                [__('admin.student_enrollments.not_create')],
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
            $this->studentRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.student_enrollments.delete')]
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
                [__('admin.student_enrollments.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

}
