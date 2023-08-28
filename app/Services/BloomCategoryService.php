<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\BloomCategory\BloomCategoriesResource;
use App\Http\Resources\BloomCategory\BloomCategoryResource;
use App\Mapper\PaginationMapper;
use App\Repositories\BloomCategoryRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BloomCategoryService
{
    /**
     * _Construct function
     *
     * @param BloomCategoryRepository $bloomCategoryRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected BloomCategoryRepository $bloomCategoryRepository,protected PaginationMapper $paginationMapper,protected ReturnData $returnData){}

    /**
     * Get ALl function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = []):array
    {
        $bloomCategory = $this->bloomCategoryRepository->getAll($options,[]);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            BloomCategoriesResource::collection($bloomCategory),
            __('admin.bloom_categories.list'),$bloomCategory instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$bloomCategory):[]
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
        $questionType = $this->bloomCategoryRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new BloomCategoryResource($questionType),
            [__('admin.bloom_categories.show')],
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
            $questionType = $this->bloomCategoryRepository->create($data);

            DB::commit();
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new BloomCategoryResource($questionType),
                    [__('admin.bloom_categories.create')]
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
                [__('admin.bloom_categories.not_create')],
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
            $questionType=$this->bloomCategoryRepository->update($data, $id);

            DB::commit();
            return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new BloomCategoryResource($questionType),
                    [__('admin.bloom_categories.update')]
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
                [__('admin.bloom_categories.not_update')],
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
            $this->bloomCategoryRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.bloom_categories.delete')]
            );
        }catch (Exception $excption) {
            logger([
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('admin.bloom_categories.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
