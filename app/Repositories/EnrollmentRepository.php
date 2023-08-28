<?php

namespace App\Repositories;
use App\Models\Country;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EnrollmentRepository extends Repository
{
    /**
     * Model function
     *
     * @return string
     */
    public function model(): string
    {
        return Enrollment::class;
    }
    /**
     * Get List function
     *
     * @param array $options
     * @param array $relation
     * @param string|null $name
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $options, array $relation=[],string $name = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $school = $options['school_id'] ?? 10;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model->where('school_id',$school);

        if (isset($name)) {
            $query = $query->where('name','like',"%$name%");
        }

        if(isset($relation)){
            $query=$query->with($relation);
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
     * Get All function
     *
     * @param array $options
     * @param int $id
     * @return LengthAwarePaginator
     */
    public function show(int $id, array $relation = []):object
    {
        $query =  $this->model;

        if(isset($relation)){
                $query=$query->with($relation);
        }

        return $query->where('id',$id)->firstOrFail();
    }

}
