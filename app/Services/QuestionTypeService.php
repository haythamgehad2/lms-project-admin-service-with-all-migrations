<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\QuestionType\QuestionTypeResource;
use App\Http\Resources\QuestionType\QuestionTypesResource;
use App\Mapper\PaginationMapper;
use App\Repositories\QuestionTypeRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QuestionTypeService
{

    /**
     * _Construct function
     *
     * @param QuestionTypeRepository $questionTypeRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected QuestionTypeRepository $questionTypeRepository,protected PaginationMapper $paginationMapper,protected ReturnData $returnData){}

    /**
     * Get ALl function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = []):array
    {
        $questionTypes = $this->questionTypeRepository->getAll($options,[]);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            QuestionTypesResource::collection($questionTypes),
            __('admin.question_types.list'),
            $questionTypes instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$questionTypes):[]
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
        $questionType = $this->questionTypeRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new QuestionTypeResource($questionType),
            [__('admin.question_types.show')],
        );
    }
    /**
     * Create function
     *
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $questionType = $this->questionTypeRepository->create($data);

            DB::commit();
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new QuestionTypeResource($questionType),
                    [__('admin.question_types.create')]
                );

        }catch (Exception $excption) {
            logger(
                [
                    'error' =>$excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.question_types.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }

    }

    /**
     * Update function
     *
     * @param array $data
     * @param integer $id
     * @return array
     */
    public function update(array $data, int $id)
    {
            DB::beginTransaction();

        try {
            $questionType=$this->questionTypeRepository->update($data, $id);

            DB::commit();
            return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new QuestionTypeResource($questionType),
                    [__('admin.question_types.update')]
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
            DB::rollback();

            return $this->returnData->create(
                [__('admin.question_types.not_update')],
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
            $this->questionTypeRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.question_types.delete')]
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

            return $this->returnData->create(
                [__('admin.question_types.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
