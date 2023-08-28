<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\DeleteAbstract;
use App\Integrations\Vimeo\Abstracts\ReplaceAbstract;
use App\Integrations\Vimeo\Abstracts\UploadAbstract;
use App\Integrations\Vimeo\Exceptions\VimeoVideoHasUploadException;
use App\Models\VideoBank;
use App\Models\VimeoVideo;

class Vimeo {
    use VimeoTrait;

    public static function pullUpload(VideoBank $videoBank) : VimeoVideo {
        $vimeoVideos = collect([]);

        $uploadObjects = collect([new Upload($videoBank)]);
        if ($videoBank->video_without_music_disk && $videoBank->video_without_music_path) {
            $uploadObjects->push(new UploadWithoutMusic($videoBank));
        }

        $uploadObjects->each(
            fn(UploadAbstract $uploadObject) => $vimeoVideos->push(self::_pullUpload($uploadObject, $videoBank))
        );
        return $vimeoVideos->first();
    }

    public static function replace(VideoBank $videoBank) : VimeoVideo | null {
        $vimeoVideos = collect([]);

        $replaceObjects = collect([new Replace($videoBank->load("firstVimeo"))]);

        if ($videoBank->video_without_music_disk && $videoBank->video_without_music_path) {
            $replaceObjects->push(new ReplaceWithoutMusic($videoBank->load("firstVimeoWithoutMusic")));
        }

        $replaceObjects->each(
            fn(ReplaceAbstract $replaceObject) => $vimeoVideos->push(self::_replace($replaceObject, $videoBank))
        );
        return $vimeoVideos->first();
    }

    public static function delete(VideoBank $videoBank) {
        $vimeoVideos = collect([]);

        collect([
            new Delete($videoBank->load("firstVimeo")),
            new DeleteWithoutMusic($videoBank->load("firstVimeoWithoutMusic")),
        ])
        ->each(
            fn(DeleteAbstract $deleteMechanism) => $vimeoVideos->push(self::_delete($deleteMechanism, $videoBank))
        );
        return $vimeoVideos->first();
    }

    public static function getVimeoVideo(VideoBank $videoBank) : array {
        try {
            $response = (new GetVimeoVideo($videoBank->load("firstVimeo")))->get();
            return $response->json("upload") ?? [];
        } catch (VimeoVideoHasUploadException $e) {
            /**
             * @todo, to be checked in case of difference use cases
             * ignore this exception catching mechanism
             * video is not uploaded at all
             */
        }
        return [];
    }

    public static function getVimeoWithoutMusic(VideoBank $videoBank) : array {
        try {
            $getMechanism = new GetVideoWithoutMusic($videoBank->load("firstVimeoWithoutMusic"));
            return $getMechanism->get()->json("upload", []);
        } catch (VimeoVideoHasUploadException $e) {
            /**
             * @todo, to be checked in case of difference use cases
             * ignore this exception catching mechanism
             * video is not uploaded at all
             */
        }
        return [];
    }
}
