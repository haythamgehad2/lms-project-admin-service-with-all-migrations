<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\Country\CountriesResource;
use App\Http\Resources\Country\CountryResource;
use App\Mapper\PaginationMapper;
use App\Repositories\CountryRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class CountryService
{
    /**
     * Undocumented function
     *
     * @param CountryRepository $countryRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected CountryRepository $countryRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData){}
    /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = [])
    {
        $countries = $this->countryRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             CountriesResource::collection($countries),
            __('admin.countries.list'),$countries instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$countries):[]
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
       $country = $this->countryRepository->show($id);

       return $this->returnData->create(
           [],
           Response::HTTP_OK,
           new CountryResource($country),
           [__('admin.countries.show')],
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
         $country = $this->countryRepository->create($data);

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new CountryResource($country),
                    [__('admin.countries.create')]
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
                [__('admin.countries.not_create')],
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
           $country=$this->countryRepository->update($data, $id);

            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new CountryResource($country),
                    [__('admin.countries.update')]
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
            [__('admin.counties.not_update')],
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
            $this->countryRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.countries.delete')]
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
                [__('admin.countries.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
