<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\LanuageMethod\LanguageMethodResource;
use App\Http\Resources\LanuageMethod\LanguageMethodsResource;
use App\Http\Resources\QuestionType\QuestionTypeResource;
use App\Http\Resources\QuestionType\QuestionTypesResource;
use App\Mapper\PaginationMapper;
use App\Repositories\LanguageMethodRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LanguageMethodService
{

    /**
     * _Construct function
     *
     * @param LanguageMethodRepository $languageMethodRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected LanguageMethodRepository $languageMethodRepository,protected PaginationMapper $paginationMapper,protected ReturnData $returnData){}

    /**
     * Get ALl function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = []):array
    {
        $langsMethods = $this->languageMethodRepository->getAll($options,[]);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            LanguageMethodsResource::collection($langsMethods),
            __('admin.language_methods.list'),
            $langsMethods instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$langsMethods):[]
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
        $questionType = $this->languageMethodRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new LanguageMethodResource($questionType),
            [ __('admin.language_methods.show')],
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
            $questionType = $this->languageMethodRepository->create($data);

            DB::commit();
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new LanguageMethodResource($questionType),
                    [__('admin.language_methods.create')]
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
                [__('admin.language_methods.not_create')],
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
            $questionType=$this->languageMethodRepository->update($data, $id);

            DB::commit();
            return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new LanguageMethodResource($questionType),
                    [__('admin.language_methods.update')]
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
                [__('admin.language_methods.not_update')],
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
            $this->languageMethodRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.language_methods.delete')]
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
                [__('admin.language_methods.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
