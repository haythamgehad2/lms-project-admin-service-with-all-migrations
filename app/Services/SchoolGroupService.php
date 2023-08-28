<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\SchoolGroup\SchoolGroupFullDetailsResource;
use App\Http\Resources\SchoolGroup\SchoolGroupResource;
use App\Http\Resources\SchoolGroup\SchoolGroupsResource;
use App\Mapper\PaginationMapper;
use App\Repositories\SchoolGroupRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class SchoolGroupService
{


    public function __construct(protected SchoolGroupRepository $schoolGroupRepository,protected PaginationMapper $paginationMapper,protected ReturnData $returnData){}


    public function getAll(array $options = [])
    {
        $schoolGroups = $this->schoolGroupRepository->getAll($options,['owner:id,first_name,email','country:id,name']);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            SchoolGroupsResource::collection($schoolGroups),
            __('admin.school_groups.list'),
            $schoolGroups instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$schoolGroups):[]
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
        $term = $this->schoolGroupRepository->show($id,['owner:id,first_name,email','country:id,name']);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new SchoolGroupResource($term),
            [__('admin.school_groups.show')],
        );
    }

    /**
     * @param int $id
    * @return array
    */
    public function fullDetails(int $id): array
    {
        $schoolGroup = $this->schoolGroupRepository->show($id, [
            'owner:id,first_name,email', 'country:id,name',
            "levels" => fn($lQuery) => $lQuery->with([
                "terms",
                "missions" => fn($q) => $q->with([
                    "level", "term", "country", "learningPaths"
                ])
            ])
        ]);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new SchoolGroupFullDetailsResource($schoolGroup),
            [__('admin.school_groups.show')],
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
            $schoolGroup = $this->schoolGroupRepository->create($data);

            DB::commit();
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new SchoolGroupResource($schoolGroup),
                    [__('admin.school_groups.create')]
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
                [__('admin.school_groups.not_create')],
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
            $schoolGroup=$this->schoolGroupRepository->update($data, $id);

            DB::commit();
            return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new SchoolGroupResource($schoolGroup),
                    [__('admin.school_groups.update')]
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
                [__('admin.school_groups.not_update')],
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
            $this->schoolGroupRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.school_groups.delete')]
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
                [__('admin.school_groups.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
