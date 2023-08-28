<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class RoleRepository extends Repository
{
    public function model(): string
    {
        return Role::class;
    }


    /**
     * Get All function
     *
     * @param array $options
     * @param string|null $name
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $options, string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $systemRole = $options['system_role'] ?? null;
        $systemEnrollment = $options['system_enrollment'] ?? null;

        $order = isset($options['order']) ? $options['order'] :'ASC';
        $name = $options['name'] ?? null;
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if(isset($name)){
            $dynamicLocale = App::getLocale();
            $query = $query->whereLike(['name->'.$dynamicLocale,'description->'.$dynamicLocale,'code'], $name);
        }

        if (isset($systemEnrollment)) {
            $query = $query->where('code', 'teacher')
            ->orWhere(function ($query) {
                $query->where('code', 'supervisor');
            });
        }
        if (isset($systemRole)) {
            $query = $query->where('system_role',$systemRole);
        }

        if (isset($order)) {
            $query = $query->orderBy('id',$order);
        }
        if(isset($listAll) && $listAll == true){
            return $query->get();
         }

        return $query->paginate($length, ['*'], 'page', $page);
    }

    /**
     * Show function
     *
     * @param array $options
     * @param string|null $name
     * @return LengthAwarePaginator
     */
    public function show(int $id):object
    {
        $query =  $this->model;
        return $query->where('id',$id)->firstOrFail();
    }

}
