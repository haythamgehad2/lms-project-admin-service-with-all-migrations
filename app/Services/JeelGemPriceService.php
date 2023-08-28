<?php
namespace App\Services;

use App\Helpers\ReturnData;
use App\Http\Resources\JeelGemPrice\JeelGemPriceResource;
use App\Mapper\PaginationMapper;
use App\Repositories\JeelGemPriceRepository;
use Illuminate\Http\Response;

class JeelGemPriceService {
    public function __construct(
        protected JeelGemPriceRepository $repository,
        protected PaginationMapper $paginationMapper,
        protected ReturnData $returnData
    ) {}

    /**
     * @param array $options
     * @return array
     */
    public function getPaginated(array $options = []) : array {
        $paginatedJeelLevelGemPrices = $this->repository->getPaginated($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            JeelGemPriceResource::collection($paginatedJeelLevelGemPrices),
            __('Jeel gem prices list returned successfully'),
            $paginatedJeelLevelGemPrices instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options, $paginatedJeelLevelGemPrices):[]
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
            new JeelGemPriceResource($this->repository->show($id)),
            [__('Jeel gem price returned successfully')],
        );
    }

    /**
     * @param array $data
     * @param integer $id
     * @return void
     */
    public function update(array $data, int $id) {
        $jeelLevelGemPrice = $this->repository->update($data, $id);
        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new JeelGemPriceResource($jeelLevelGemPrice),
            [__('Jeel gem price has been updated')]
        );
    }
}
