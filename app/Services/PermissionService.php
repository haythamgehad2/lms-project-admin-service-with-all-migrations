<?php

namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\PermissionCollection;
use App\Mapper\PaginationMapper;
use App\Mapper\PermissionMapper;
use App\Repositories\PermissionRepository;
use Exception;
use Illuminate\Http\Response;

class PermissionService
{


    public function __construct(protected PermissionMapper $permissionMapper,protected PermissionRepository $permissionRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData)
    {

    }

    /**
     * getAll function
     *
     * @param array $options
     * @return void
     */
    public function getAll(array $options = [])
    {
        $permissions = $this->permissionRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new permissionCollection($permissions),
            [__('permissions list returned successfully')],
            $permissions instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$permissions):[]
        );
    }


    public function create(array $data)
    {
        try {
            $mappedData = $this->permissionMapper->mapCreate($data);
            if ($permission = $this->permissionRepository->create($mappedData)) {

                if(isset($data['roles']) && count($data['roles'])> 0)
                    $permission->roles()->attach($data['roles']);
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    $permission,
                    [__('permission has been created')]
                );
            }
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
            [__('permission has not been created')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }

    public function update(array $data, int $id)
    {
        try {
            $permission = $this->permissionRepository->find($id);
            if (!$permission) {
                return $this->returnData->create(
                    [__('permission not found')],
                    Response::HTTP_NOT_FOUND,
                    []
                );
            }
            $mappedData = $this->permissionMapper->mapUpdate($data);
            if ($this->permissionRepository->update($mappedData, $id)) {

                if(isset($data['roles']) && count($data['roles'])> 0){
                    $permission->roles()->detach();
                    $permission->roles()->attach($data['roles']);
                }
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    $permission->fresh(),
                    [__('permission has been created')]
                );
            }
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
            [__('permission has not been deleted')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
    }

    public function delete(int $id)
    {
        try {
            $this->permissionRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('permission has been deleted')]
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
            [__('permission has not been deleted')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }
}
