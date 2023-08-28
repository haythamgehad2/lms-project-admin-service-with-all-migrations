<?php
namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\RewardAction\RewardActionResource;
use App\Http\Resources\RewardAction\RewardActionsResource;
use App\Mapper\PaginationMapper;
use App\Repositories\RewardActionRepository;
use Illuminate\Http\Response;

class RewardActionService {
    public function __construct(
        protected RewardActionRepository $repository,
        protected PaginationMapper $paginationMapper,
        protected ReturnData $returnData
    ) {}

    /**
     * @param array $options
     * @return array
     */
    public function getPaginated(array $options = []) : array {
        $paginatedRewards = $this->repository->getPaginated($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            RewardActionsResource::collection($paginatedRewards),
            __('Reward actions list returned successfully'),
            $paginatedRewards instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options, $paginatedRewards):[]
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
            new RewardActionResource($this->repository->show($id)),
            [__('Reward action returned successfully')],
        );
    }

    /**
     * @param array $data
     * @param integer $id
     * @return void
     */
    public function update(array $data, int $id) {
        $rewardAction = $this->repository->update($data, $id);
        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new RewardActionResource($rewardAction),
            [__('Reward action has been updated')]
        );
    }
}
