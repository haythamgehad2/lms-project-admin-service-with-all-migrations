<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\LanuageSkill\LanguageSkillResource;
use App\Http\Resources\LanuageSkill\LanguageSkillsResource;
use App\Http\Resources\QuestionType\QuestionTypeResource;
use App\Http\Resources\QuestionType\QuestionTypesResource;
use App\Mapper\PaginationMapper;
use App\Repositories\LanguageSkillRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LanguageSkillService
{

    /**
     * _Construct function
     *
     * @param LanguageSkillRepository $languageSkillRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected LanguageSkillRepository $languageSkillRepository,protected PaginationMapper $paginationMapper,protected ReturnData $returnData){}

    /**
     * Get ALl function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = []):array
    {
        $lanugages = $this->languageSkillRepository->getAll($options,[]);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            LanguageSkillsResource::collection($lanugages),
            __('admin.language_skills.list'),
            $lanugages instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$lanugages):[]
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
        $lanugage = $this->languageSkillRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new LanguageSkillResource($lanugage),
            [__('admin.language_skills.show')],
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
            $lanugage = $this->languageSkillRepository->create($data);

            DB::commit();
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new LanguageSkillResource($lanugage),
                    [__('admin.language_skills.create')]
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
                [__('admin.language_skills.not_create')],
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
            $lanugage=$this->languageSkillRepository->update($data, $id);

            DB::commit();
            return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new LanguageSkillResource($lanugage),
                    [__('admin.language_skills.update')]
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
                [__('admin.language_skills.not_update')],
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
            $this->languageSkillRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.language_skills.delete')]
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
                [__('admin.language_skills.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
