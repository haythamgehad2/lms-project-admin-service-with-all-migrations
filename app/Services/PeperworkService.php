<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\PeperWork\PeperWorkResoruce;
use App\Http\Resources\PeperWork\PeperWorksResoruce;
use App\Mapper\PaginationMapper;
use App\Models\PeperWork;
use App\Repositories\PeperworkRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PeperworkService
{


    /**
     * __Construct function
     *
     * @param PeperworkRepository $peperworkRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected PeperworkRepository $peperworkRepository,protected PaginationMapper $paginationMapper, protected ReturnData $returnData){}


    /**
     * GetAll function
     * @param array $options
     * @return void
     */
    public function getAll(array $options = [])
    {
        $peperWorks = $this->peperworkRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             PeperWorksResoruce::collection($peperWorks),
            [__('admin.paper_works.list')],
            $peperWorks instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$peperWorks):[]
        );
    }

    /**
    * Show function
    *
    * @param array $options
    * @return void
    */
    public function show(int $id)
    {
        $peperWork = $this->peperworkRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new PeperWorkResoruce($peperWork),
            [__('admin.paper_works.show')],
        );
    }

    /**
     * Create function
     *
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
            DB::beginTransaction();

        try {


            $ext = '.'.request()->file->getClientOriginalExtension();
            $paperWithColorName = 'paper_work-with-color-'. time() . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('papers_work'), $paperWithColorName);
            $data['disk']='papers_work';
            $data['path']=$paperWithColorName;


            if ($paperWithoutColor = request()->file("paper_work_without_color", null)) {

                $paperWithoutColorName = 'paper_work-without-color-'. time() . '.' . $paperWithoutColor->getClientOriginalExtension();
                $paperWithoutColor->move(public_path('papers_work'), $paperWithoutColorName);
                $data['paper_work_without_color_disk'] = 'papers_work';
                $data['paper_work_without_color_path'] = $paperWithoutColorName;
            }

            $peperWork = $this->peperworkRepository->create($data);


            if(isset($data['thumbnail'])){
                $peperWork->saveFiles($data['thumbnail']);
            }


            DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new PeperWorkResoruce($peperWork),
                    [__('admin.paper_works.create')]
                );

        }catch(Exception $excption) {
            dd($excption->getMessage());
            logger(
                [
                    'error'=> $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );
            DB::rollback();


            return $this->returnData->create(
                [__('admin.paper_works.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

    /**
     * Update function
     *
     * @param array $data
     * @param integer $id
     * @return array
     */
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {

            if(isset($data['file'])) {

                $file=PeperWork::findOrfail($id);
                File::delete(public_path().'/'.'papers_work/'.$file->path);

                $ext = '.'.request()->file->getClientOriginalExtension();
                $paperWithColorName = 'paper_work-with-color-'. time() . '.' . request()->file->getClientOriginalExtension();
                request()->file->move(public_path('papers_work'), $paperWithColorName);
                $data['disk']='papers_work';
                $data['path']=$paperWithColorName;

            }

            if ($paperWithoutColor = request()->file("paper_work_without_color", null)) {

                $file=PeperWork::findOrfail($id);
                File::delete(public_path().'/'.'papers_work/'.$file->paper_work_without_color_path);


                $paperWithoutColorName = 'paper_work-without-color-'. time() . '.' . $paperWithoutColor->getClientOriginalExtension();
                $paperWithoutColor->move(public_path('papers_work'), $paperWithoutColorName);

                $data['paper_work_without_color_disk'] = 'papers_work';
                $data['paper_work_without_color_path'] = $paperWithoutColorName;
            }

          $peperWork =$this->peperworkRepository->update($data, $id);

            if(isset($data['thumbnail'])){
                $peperWork->updateFile($data['thumbnail']);
            }

           DB::commit();

                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new PeperWorkResoruce($peperWork),
                    [__('admin.paper_works.update')]
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
        DB::rollback();

        return $this->returnData->create(
            [__('admin.paper_works.not_update')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );
        }

    }

    /**
     * Delete function
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id)
    {
        try {

            $file=PeperWork::findOrfail($id);

            if(File::exists(public_path().'/'.'papers_work/'.$file->path)){
                File::delete(public_path().'/'.'papers_work/'.$file->path);
            }

            if(File::exists(public_path().'/'.'papers_work/'.$file->paper_work_without_color_path)){
                File::delete(public_path().'/'.'papers_work/'.$file->paper_work_without_color_path);
            }

            $this->peperworkRepository->delete($id);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.paper_works.delete')]
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


        return $this->returnData->create(
            [__('admin.paper_works.not_delete')],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            []
        );

        }
    }
     /**
     * Delete function
     *
     * @param integer $id
     * @return array
     */
    public function deleteFile(int $id)
    {
        try {
            $file=PeperWork::findOrfail($id);

            if(File::exists(public_path().'/'.'papers_work/'.$file->path)){
                File::delete(public_path().'/'.'papers_work/'.$file->path);
            }
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.paper_works.delete')]
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

            return $this->returnData->create(
                [__('admin.paper_works.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

     /**
     * Delete function
     *
     * @param integer $id
     * @return array
     */
    public function uplodeFile(int $id)
    {
        try {
            $file=PeperWork::findOrfail($id);

            $ext = '.'.request()->file->getClientOriginalExtension();
            $fileName = time() . '.' . request()->file->getClientOriginalExtension();
            request()->file->move(public_path('papers_work'), $fileName);

            $file->disk='papers_work';
            $file->path=$fileName;
            $file->save();


            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.paper_works.create')]
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

            return $this->returnData->create(
                [__('admin.paper_works.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
