<?php
namespace App\Repositories;

use App\Models\StudentActionHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentActionHistoryRepository extends Repository
{

    public function model(): string
    {
        return StudentActionHistory::class;
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
            ->when($options['student_id'] ?? false, fn($q) => $q->studentId($options['student_id']))
            ->when(!isset($options['student_id']), fn($q) => $q->with("student"))
            ->with("rewardAction")
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
