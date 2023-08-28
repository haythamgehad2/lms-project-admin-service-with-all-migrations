<?php
namespace App\Repositories;

use App\Models\JeelLevelXp;
use App\Models\RewardAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class JeelLevelXpRepository extends Repository
{

    public function model(): string
    {
        return JeelLevelXp::class;
    }

    /**
     * @param array $options
     * @return LengthAwarePaginator|Collection
     */
    public function getPaginated(array $options = []): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) && in_array($options['order'], ['asc', 'desc']) ? $options['order'] :'asc';

        return $this->model
            ->orderBy("id", $order)
            ->paginate($length, ['*'], 'page', $page);
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
