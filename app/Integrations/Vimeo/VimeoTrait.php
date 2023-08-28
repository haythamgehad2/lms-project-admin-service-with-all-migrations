<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Abstracts\DeleteAbstract;
use App\Integrations\Vimeo\Abstracts\ReplaceAbstract;
use Error;
use Exception;
use App\Models\VideoBank;
use App\Models\VimeoVideo;
use Illuminate\Support\Str;
use App\Integrations\Vimeo\Abstracts\UploadAbstract;
use App\Integrations\Vimeo\Exceptions\DeleteException;
use App\Integrations\Vimeo\Exceptions\UploadException;
use App\Integrations\Vimeo\Exceptions\VimeoVideoHasUploadException;

trait VimeoTrait {
    private static function _pullUpload(UploadAbstract $uploadObject, VideoBank $videoBank) : VimeoVideo {
        try {
            $resultJson = $uploadObject->pullUpload()->json();
            $vimeoVideoData = [
                "vimeo_video_id" => Str::replace("/videos/", "", $resultJson["uri"]),
                "video_bank_id" => $videoBank->id,
                "is_fully_uploaded" => false,
                "vimeo_response" => $resultJson,
                "vimeo_private_link" => $resultJson["link"],
            ];
        } catch (Exception | Error $e) {
            $vimeoVideoData = [
                "video_bank_id" => $videoBank->id,
                "upload_error" => $e->getMessage(),
            ];
        }
        $vimeoVideoData['has_music'] = $uploadObject instanceof Upload;
        return VimeoVideo::create($vimeoVideoData);
    }

    private static function _replace(
        ReplaceAbstract $replaceMechanism,
        VideoBank $videoBank
    ) : VimeoVideo | null
    {
        try {
            $resultJson = $replaceMechanism->replacePullUpload()->json();
            $firstVimeo = $replaceMechanism instanceof Replace ? $videoBank->firstVimeo : $videoBank->firstVimeoWithoutMusic;

            $vimeoVideoData = [
                "vimeo_video_id" => $firstVimeo->vimeo_video_id,
                "video_bank_id" => $videoBank->id,
                "is_fully_uploaded" => false,
                "vimeo_response" => $resultJson,
                "vimeo_private_link" => $firstVimeo->vimeo_private_link,
                'has_music' => $replaceMechanism instanceof Replace
            ];

            if ($replaceMechanism instanceof Replace) {
                $videoBank->allVimeo()->update(['is_replaced' => true]);
            } else {
                $videoBank->allVimeoWithoutMusic()->update(['is_replaced' => true]);
            }
            return VimeoVideo::create($vimeoVideoData);
        } catch (VimeoVideoHasUploadException $e) {
            return self::pullUpload($videoBank);
        } catch (UploadException $e) {
            /**
             * @todo, to be checked in case of difference use cases
             * ignore this exception catching mechanism
             * video is already exists at vimeo and has the required data in our DB
             */
        }
        return null;
    }

    private static function _delete(DeleteAbstract $deleteMechanism, VideoBank $videoBank) {
        try {
            $deleteResponse = $deleteMechanism->delete();
            if ($deleteResponse->successful()) {
                if ($deleteMechanism instanceof Delete) {
                    $videoBank->allVimeo()->delete();
                } else {
                    $videoBank->allVimeoWithoutMusic()->delete();
                }
            }
        } catch (DeleteException | VimeoVideoHasUploadException $e) {
            /**
             * @todo, to be checked in case of difference use cases
             * ignore this exception catching mechanism
             * video is not uploaded at all or delete operation failed
             */
        }
    }
}
