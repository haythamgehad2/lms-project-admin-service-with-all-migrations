<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\Video\VideoResource;
use App\Http\Resources\Video\VideosResource;
use App\Integrations\Vimeo\Vimeo;
use App\Mapper\PaginationMapper;
use App\Models\PeperWork;
use App\Models\VideoBank;
use App\Repositories\VideoBankRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VideoBankService
{
    /**
     * Undocumented function
     *
     * @param VideoBankRepository $videoBankRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(
        protected VideoBankRepository $videoBankRepository,
        protected PaginationMapper $paginationMapper,
        protected ReturnData $returnData
    ) {}

    /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = [])
    {
        $videos = $this->videoBankRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
             VideosResource::collection($videos),
            __('admin.videobanks.list'),
            $videos instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$videos):[]
        );
    }

    /**
    * Show function
    *video
    * @param array $options
    * @return void
    */
    public function show(int $id)
    {
        $video = $this->videoBankRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new videoResource($video),
            [__('admin.videobanks.show')],
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
        try {
            DB::beginTransaction();

            $videoWithoutMusicName = 'video-with-music-'. time() . '.' . request()->video->getClientOriginalExtension();
            request()->video->move(public_path('videos_disk'), $videoWithoutMusicName);
            $data['disk']='videos_disk';
            $data['path']=$videoWithoutMusicName;
            $data['processed']='0';

            if ($videoWithoutMusic = request()->file("video_without_music", null)) {
                $videoWithoutMusicName = 'video-without-music-'. time() . '.' . $videoWithoutMusic->getClientOriginalExtension();
                $videoWithoutMusic->move(public_path('videos_disk'), $videoWithoutMusicName);
                $data['video_without_music_disk'] = 'videos_disk';
                $data['video_without_music_path'] = $videoWithoutMusicName;
            }

            $video = $this->videoBankRepository->create($data);

            if(isset($data['thumbnail'])){
                $video->saveFiles($data['thumbnail']);
            }

            DB::commit();

            Vimeo::pullUpload($video);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                new videoResource($video),
                [__('admin.videobanks.create')]
            );

        } catch (Exception $excption) {
            logger([
                'error'=>$excption->getMessage(),
                'code' => $excption->getCode(),
                'file' => $excption->getFile(),
                'line' => $excption->getLine(),
            ]);

            DB::rollback();

            return $this->returnData->create(
                [__('admin.videobanks.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }

     /**
     * Update function
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function update(array $data, int $id)
    {
        try {
            DB::beginTransaction();
            $isVideoUploaded = false;

            if(isset($data['video'])) {
                $file=VideoBank::findOrfail($id);
                File::delete(public_path().'/'.'videos_disk/'.$file->path);
                $videoWithoutMusicName = 'video-with-music-'. time() . '.' . request()->video->getClientOriginalExtension();
                request()->video->move(public_path('videos_disk'), $videoWithoutMusicName);
                $data['disk']='videos_disk';
                $data['path']=$videoWithoutMusicName;

            }

            if ($videoWithoutMusic = request()->file("video_without_music", null)) {
                $file=PeperWork::findOrfail($id);
                File::delete(public_path().'/'.'videos_disk/'.$file->video_without_music_path);
                $videoWithoutMusicName = 'video-without-music-'. time() . '.' . $videoWithoutMusic->getClientOriginalExtension();
                $videoWithoutMusic->move(public_path('videos_disk'), $videoWithoutMusicName);
                $data['video_without_music_disk'] = 'videos_disk';
                $data['video_without_music_path'] = $videoWithoutMusicName;

                $isVideoUploaded = true;
            }

           $video = $this->videoBankRepository->update($data, $id);

            if(isset($data['thumbnail'])){
                $video->updateFile($data['thumbnail']);
            }

            if ($isVideoUploaded) Vimeo::replace($video);

            DB::commit();

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                new VideoResource($video),
                [__('admin.videobanks.update')]
            );
        } catch (Exception $excption) {
            logger([
                'error' => $excption->getMessage(),
                'code' => $excption->getCode(),
                'file' => $excption->getFile(),
                'line' => $excption->getLine(),
            ]);

            DB::rollback();
            return $this->returnData->create(
                [__('admin.videobanks.not_update')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }


     /**
     * Update function
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function removeThumbnail(int $id)
    {
        try {
            DB::beginTransaction();

            $video = $this->videoBankRepository->find($id);

            if(isset($data['thumbnail'])){
                $video->removeFile($data['thumbnail']);
            }

            DB::commit();

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.videobanks.remove_thumbnail')]
            );
        } catch (Exception $excption) {
            logger([
                'error' => $excption->getMessage(),
                'code' => $excption->getCode(),
                'file' => $excption->getFile(),
                'line' => $excption->getLine(),
            ]);

            DB::rollback();
            return $this->returnData->create(
                [__('admin.videobanks.not_remove_thumbnail')],
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
            $vid = VideoBank::findOrFail($id);

            if (File::exists(public_path().'/'.'videos_disk/'.$vid->path)) {
                File::delete(public_path().'/'.'videos_disk/'.$vid->path);
            }

            if (
                $vid->video_without_music_disk &&
                $vid->video_without_music_path &&
                File::exists(public_path("{$vid->video_without_music_disk}/{$vid->video_without_music_path}"))
            ) File::delete(public_path("{$vid->video_without_music_disk}/{$vid->video_without_music_path}"));

            Vimeo::delete($vid);

            $this->videoBankRepository->delete($id);

            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.videobanks.delete')]
            );
        } catch (Exception $excption) {
            logger([
                'error' => $excption->getMessage(),
                'code' => $excption->getCode(),
                'file' => $excption->getFile(),
                'line' => $excption->getLine(),
            ]);

            return $this->returnData->create(
                [__('admin.videobanks.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
