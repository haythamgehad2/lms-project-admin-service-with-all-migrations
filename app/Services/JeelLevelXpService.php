<?php
namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\JeelLevelXp\JeelLevelXpResource;
use App\Mapper\PaginationMapper;
use App\Repositories\JeelLevelXpRepository;
use Illuminate\Http\Response;

class JeelLevelXpService {
    public function __construct(
        protected JeelLevelXpRepository $repository,
        protected PaginationMapper $paginationMapper,
        protected ReturnData $returnData
    ) {}

    /**
     * @param array $options
     * @return array
     */
    public function getPaginated(array $options = []) : array {
        $paginatedJeelLevelXp = $this->repository->getPaginated($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            JeelLevelXpResource::collection($paginatedJeelLevelXp),
            __('Jeel level xps list returned successfully'),
            $paginatedJeelLevelXp instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options, $paginatedJeelLevelXp):[]
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
            new JeelLevelXpResource($this->repository->show($id)),
            [__('Jeel level xp returned successfully')],
        );
    }

    /**
     * @param array $data
     * @param integer $id
     * @return void
     */
    public function update(array $data, int $id) {
        $jeelLevelXp = $this->repository->update($data, $id);
        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new JeelLevelXpResource($jeelLevelXp),
            [__('Jeel level xp has been updated')]
        );
    }
}
