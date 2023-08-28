<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\Level\LevelMissionsInfoResource;
use App\Http\Resources\Level\LevelResource;
use App\Http\Resources\Level\LevelsResource;
use App\Http\Resources\LevelCollection;
use App\Mapper\PaginationMapper;
use App\Mapper\LevelMapper;
use App\Models\Level;
use App\Repositories\LevelRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LevelService
{


    public function __construct(protected LevelRepository $levelRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData){}


    public function getAll(array $options = [])
    {

        $levels = $this->levelRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             LevelsResource::collection($levels),
            __('admin.levels.list'),
            $levels instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$levels):[]
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
           $level = $this->levelRepository->show($id);

           return $this->returnData->create(
               [],
               Response::HTTP_OK,
               new LevelResource($level),
               [__('admin.levels.show')],
           );
       }

        /**
        * Show function
        *
        * @param array $options
        * @return void
        */
       public function showSchoolLevels(int $id)
       {
           $level = $this->levelRepository->show($id);

           return $this->returnData->create(
               [],
               Response::HTTP_OK,
               new LevelMissionsInfoResource($level),
               [__('admin.levels.show')],
           );
       }



    public function create(array $data)
    {
        DB::beginTransaction();

        try {
          $level = $this->levelRepository->create($data);

          if(isset($data['themes'])){
              $level->themes()->attach($data['themes']);
          }

          if(isset($data['school_groups']))
            $level->school_groups()->attach($data['school_groups']);

          DB::commit();
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                     New LevelResource($level),
                    [__('admin.levels.create')]
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
        DB::rollBack();

        return $this->returnData->create(
            [__('admin.levels.not_create')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }

    public function update(array $data, int $id)
    {
            DB::beginTransaction();

        try {

            $level=$this->levelRepository->update($data, $id);
            if(isset($data['themes'])){
                $level->themes()->sync($data['themes']);

            }

            DB::commit();

            return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    New LevelResource($level),
                    [__('admin.levels.update')]
                );

        }catch (Exception $excption) {
            logger([
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollBack();

            return $this->returnData->create(
                [__('admin.levels.not_updete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }


    }

    /**
     * delete function
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        try {
            $this->levelRepository->delete($id);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.levels.delete')]
            );

        }catch (Exception $excption) {
            logger(
                [
                    'error'=> $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('admin.levels.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }



}
