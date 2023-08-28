<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\SchoolType\SchoolTypeResource;
use App\Http\Resources\SchoolType\SchoolTypesResource;
use App\Http\Resources\SchoolTypeCollection;
use App\Mapper\PaginationMapper;
use App\Repositories\SchoolTypeRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SchoolTypeService
{


    public function __construct(protected SchoolTypeRepository $schoolTypeRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData){}


    /**
     * GetAll function
     * @param array $options
     * @return void
     */
    public function getAll(array $options = [])
    {
        $schoolTypes = $this->schoolTypeRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             SchoolTypesResource::collection($schoolTypes),
            [__('admin.school_types.list')],
            $schoolTypes instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$schoolTypes):[]
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
        $term = $this->schoolTypeRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new SchoolTypeResource($term),
            [__('admin.school_types.show')],
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
            $schoolType = $this->schoolTypeRepository->create($data);

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new SchoolTypeResource($schoolType),
                    [__('admin.school_types.create')]
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
                [__('admin.school_types.not_create')],
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
     * @return void
     */
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {

           $schoolType =$this->schoolTypeRepository->update($data, $id);

           DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new SchoolTypeResource($schoolType),
                    [__('admin.school_types.update')]
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
        DB::rollback();

        return $this->returnData->create(
            [__('admin.school_types.not_create')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
        }

    }

    /**
     * Delete function
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        try {
            $this->schoolTypeRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.school_types.delete')]
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
            [__('admin.school_types.not_delete')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

        }
    }
}
