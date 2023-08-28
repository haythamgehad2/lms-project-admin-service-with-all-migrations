<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\LearningPath\LearningPathResource;
use App\Http\Resources\LearningPath\LearningPathsResource;
use App\Mapper\PaginationMapper;
use App\Repositories\LearningPathRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class LearningPathService
{
    /**
     * Undocumented function
     *
     * @param LearningPathRepository $learningPathRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected LearningPathRepository $learningPathRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData){}
    /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = [])
    {
        $learningPaths = $this->learningPathRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             LearningPathsResource::collection($learningPaths),
             __('admin.learningpaths.list'),
            $learningPaths instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$learningPaths):[],
        );
    }
    /**
    * Show function
    *
    * @param array $options
    * @return void
    */
   public function show(int $id)
   {
       $learningPath = $this->learningPathRepository->show($id);

       return $this->returnData->create(
           [],
           Response::HTTP_OK,
           new LearningPathResource($learningPath),
           [__('admin.learningpaths.show')],
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

            $learningPath = $this->learningPathRepository->create($data);

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new LearningPathResource($learningPath),
                    [__('admin.learningpaths.create')]
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
                [__('admin.learningpaths.not_create')],
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
    public function learningPathManageStatus(array $data)
    {

        DB::beginTransaction();

        try {

            $learningPath = $this->learningPathRepository->find($data['learningpath_id']);
            $learningPathMission=$learningPath->missions()->updateExistingPivot($data['mission_id'],['is_selected'=>$data['is_selected']]);

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    [],
                    [__('admin.learningpaths.learningpath_status_change_success')]
                );

        }catch (Exception $excption) {
            logger([
                    'error'=>$excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.learningpaths.learningpath_status_not_change_success')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
     /**
     * Update function
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function update(array $data, int $id)
    {

           DB::beginTransaction();

        try {
           $learningPath=$this->learningPathRepository->update($data, $id);

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new LearningPathResource($learningPath),
                    [__('admin.learningpaths.update')]
                );

        }catch(Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );
            DB::rollback();

        return $this->returnData->create(
            [__('admin.learningpaths.not_update')],
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
            $this->learningPathRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.learningpaths.delete')]
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
                [__('admin.learningpaths.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
