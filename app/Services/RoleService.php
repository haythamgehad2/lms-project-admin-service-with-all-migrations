<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\RolesResource;
use App\Http\Resources\RoleCollection;
use App\Mapper\PaginationMapper;
use App\Mapper\RoleMapper;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class RoleService
{


    public function __construct(protected RoleMapper $roleMapper,protected RoleRepository $roleRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData)
    {}


    /**
     * Get All function
     *
     * @param array $options
     * @return void
     */
    public function getAll(array $options = [])
    {
        $roles = $this->roleRepository->getAll($options,
        isset($options['name']) ? $options['name'] : null);


        $roles = $this->roleRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            RolesResource::collection($roles),
            [__('admin.roles.list')], $roles instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$roles):[]
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
       $term = $this->roleRepository->show($id);

       return $this->returnData->create(
           [],
           Response::HTTP_OK,
           new RoleResource($term),
           [__('admin.roles.show')],
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
        try {
            $role = $this->roleRepository->create($data);

                if(isset($data['permissions']) && count($data['permissions'])> 0)
                    $role->permissions()->attach($data['permissions']);


                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new RoleResource($role),
                    [__('admin.roles.create')]
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
                    [__('admin.roles.not_create')],
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
        try {

            $role=$this->roleRepository->update($data, $id);

            if($role->is_default == 0){
                    if(isset($data['permissions']) && count($data['permissions'])> 0){
                        $role->permissions()->sync($data['permissions']);
                    }
            }
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new RoleResource($role),
                    [__('admin.roles.update')]
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
            [__('admin.roles.not_update')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
    }

    public function delete(int $id)
    {
        try {
            $role=$this->roleRepository->find($id);

            if($role->is_default == 0){
                 $this->roleRepository->delete($id);
            }else{
                return $this->returnData->create(
                    [__('admin.roles.default_role_delete')],
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    []
                );
            }

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.roles.delete')]
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
            [__('admin.roles.not_delete')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }



}
