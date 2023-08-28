<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\Term\TermResource;
use App\Http\Resources\Term\TermsResource;
use App\Mapper\PaginationMapper;
use App\Mapper\TermMapper;
use App\Models\Term;
use App\Repositories\TermRepository;
use Exception;
use Illuminate\Http\Response;

class TermService
{


    public function __construct(protected TermMapper $termMapper,protected TermRepository $termRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData)
    {

    }


    public function getAll(array $options = [])
    {
        $terms = $this->termRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             TermsResource::collection($terms),
            __('admin.terms.list'),
            $terms instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$terms):[]
        );
    }

     /**
    * GetAll function
    *
    * @param array $options
    * @return void
    */
   public function show(int $id)
   {
       $term = $this->termRepository->show($id);

       return $this->returnData->create(
           [],
           Response::HTTP_OK,
           new TermResource($term),
           [__('admin.terms.show')]
       );
   }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        try{

            $term = $this->termRepository->create($data);

           if(isset($data['school_id'])){
            $term->levels()->attach($data['levels'],['school_id'=>$data['school_id']]);

           }else{
            $term->levels()->attach($data['levels']);
           }

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new TermResource($term),
                    [__('admin.terms.create')]
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
            [__('admin.terms.create')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @param integer $id
     * @return array
     */
    public function update(array $data, int $id)
    {
        try {
            $term =$this->termRepository->update($data, $id);


            $term->levels()->sync($data['levels']);




                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new TermResource($term),
                    [__('admin.terms.update')]
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
            [__('admin.terms.not_update')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
    }

    public function delete(int $id)
    {
        try{
            $this->termRepository->delete($id);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.terms.delete')]
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
            [__('admin.terms.not_delete')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
    }
}
