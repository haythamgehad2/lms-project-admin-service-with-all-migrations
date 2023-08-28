<?php

namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\ThemeCollection;
use App\Http\Resources\ThemeResource;
use App\Mapper\PaginationMapper;
use App\Mapper\ThemeMapper;
use App\Models\Theme;
use App\Repositories\ThemeRepository;
use Exception;
use Illuminate\Http\Response;

class ThemeService
{


    /**
     * Undocumented function
     *
     * @param ThemeMapper $themeMapper
     * @param ThemeRepository $levelRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected ThemeMapper $themeMapper,protected ThemeRepository $themeRepository
    ,protected PaginationMapper $paginationMapper, protected ReturnData $returnData)
    {

    }


    /**
     * GetAll function
     *
     * @param array $options
     * @return void
     */
    public function getAll(array $options = [])
    {
        $themes = $this->themeRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new ThemeCollection($themes),
            [__('theme list returned successfully')],
            $themes instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$themes):[]
        );
    }

    /**
    * GetAll function
    *
    * @param array $options
    * @return void
    */
   public function show(int $id)
   {
       $theme = $this->themeRepository->show($id);

       return $this->returnData->create(
           [],
           Response::HTTP_OK,
           new ThemeResource($theme),
           [__('theme item returned successfully')]
       );
   }

    /**
     * Create function
     *
     * @param array $data
     * @return array
     */
    public function create(array $data) : array
    {
        try {
            $mappedData = $this->themeMapper->mapCreate($data);
            if ($theme = $this->themeRepository->create($mappedData)) {

                $theme->saveFiles($data['image']);

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new ThemeResource($theme),
                    [__('theme has been created')]
                );
            }
        } catch (Exception $excption) {
            logger(
                [
                    'error'=> $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );
        }

        return $this->returnData->create(
            [__('theme has not been created')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }

    /**
     * Update function
     *
     * @param array $data
     * @param integer $id
     * @return array
     */
    public function update(array $data, int $id) :array
    {
        try {
            $theme = $this->themeRepository->find($id);
            if (!$theme) {
                return $this->returnData->create(
                    [__('theme not found')],
                    Response::HTTP_NOT_FOUND,
                    []
                );
            }
            $mappedData = $this->themeMapper->mapUpdate($data);

            if ($update=$this->themeRepository->update($mappedData, $id)){

                $theme->updateFile($data['image']);

                if(isset($data['permissions']) && count($data['permissions'])> 0){
                    $theme->permissions()->detach();
                    $theme->permissions()->attach($data['permissions']);
                }
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    $theme->fresh(),
                    [__('theme has been edited')]
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
            [__('theme has not been edited')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
    }

    /**
     * Delete function
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id):array
    {
        try {
            $this->themeRepository->delete($id);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('theme has been deleted')]
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
            [__('theme has not been deleted')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

    }
}
