<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\Package\PackageResoruce;
use App\Http\Resources\Package\PackagesResoruce;
use App\Http\Resources\PackageCollection;
use App\Mapper\PaginationMapper;
use App\Mapper\PackageMapper;
use App\Models\Package;
use App\Repositories\PackageRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PackageService
{


    public function __construct(protected PackageRepository $packageRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData)
    {

    }


    public function getAll(array $options = [])
    {

        $packages = $this->packageRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             PackagesResoruce::collection($packages),
            [__('admin.pacakges.list')],
            $packages instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$packages):[],
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
        $term = $this->packageRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new PackageResoruce($term),
            [__('school group item returned successfully')],
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
            $package = $this->packageRepository->create($data);

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new PackageResoruce($package),
                    [__('admin.pacakges.create')]
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

            DB::rollBack();

            return $this->returnData->create(
                [__('admin.pacakges.not_create')],
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

            $package=$this->packageRepository->update($data, $id);


            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new PackageResoruce($package),
                    [__('admin.pacakges.update')]
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
            DB::rollBack();

            return $this->returnData->create(
                [__('admin.pacakges.not_update')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }


    }

    public function delete(int $id)
    {
        try {
            $this->packageRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.pacakges.delete')]
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
        }

        return $this->returnData->create(
            [__('admin.pacakges.not_delete')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }
}
