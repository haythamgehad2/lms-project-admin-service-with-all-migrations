<?php
namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\StudentActionHistory\StudentActionHistoriesResource;
use App\Mapper\PaginationMapper;
use App\Repositories\StudentActionHistoryRepository;
use Illuminate\Http\Response;

class StudentActionHistoryService {
    public function __construct(
        protected StudentActionHistoryRepository $repository,
        protected PaginationMapper $paginationMapper,
        protected ReturnData $returnData
    ) {}

    /**
     * @param array $options
     * @return array
     */
    public function getPaginated(array $options = []) : array {
        
        $studentActionHistoryPaginated = $this->repository->getPaginated($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            StudentActionHistoriesResource::collection($studentActionHistoryPaginated),
            __('Student action history list returned successfully'),
            $studentActionHistoryPaginated instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options, $studentActionHistoryPaginated):[]
        );
    }

    /**
     * @param integer $id
     * @return array
     */
    public function show(int $id) : array {
        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new StudentActionHistoriesResource($this->repository->show($id, ["rewardAction", "student"])),
            [__('Student action history returned successfully')],
        );
    }
}
