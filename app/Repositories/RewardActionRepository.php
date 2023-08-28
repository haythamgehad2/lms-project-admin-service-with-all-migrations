<?php
namespace App\Repositories;

use App\Models\RewardAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class RewardActionRepository extends Repository
{

    public function model(): string
    {
        return RewardAction::class;
    }

    /**
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function getPaginated(array $options = []): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) && in_array($options['order'], ['asc', 'desc']) ? $options['order'] :'asc';
        $name = $options['name'] ?? null;

        $query =  $this->model;


        if(isset($name)){
            $query = $query->whereLike(['action_name','action_desc'], $name);
        }

        return $query->orderBy("id", $order)->paginate($length, ['*'], 'page', $page);
    }

    /**
     * @param int $id
     * @param array $options
     * @return object
     */
    public function show(int $id, array $relation = []) : object
    {
        return $this->model
            ->when(!empty($relation), fn($q) => $q->with($relation))
            ->where('id', $id)
            ->firstOrFail();
    }

}
