<?php
namespace App\Integrations\Vimeo\Abstracts;

use App\Integrations\Vimeo\Exceptions\DeleteException;
use Error;
use Exception;
use App\Models\VideoBank;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Integrations\Vimeo\Exceptions\VimeoVideoHasUploadException;
use App\Models\VimeoVideo;

abstract class DeleteAbstract {
    protected string $accessToken;

    public function __construct(
        protected VideoBank $videoBank
    ) {
        $this->accessToken = config("vimeo.api_token");
    }

    protected abstract function getFirstVimeo() : VimeoVideo | null;

    public function delete() : Response {
        $firstVimeo = $this->getFirstVimeo();
        if (!$firstVimeo) throw new VimeoVideoHasUploadException;

        $msg = "";
        $line = "";
        $file = "";

        try {
            $url = config("vimeo.api_url") . "/videos/{$firstVimeo->vimeo_video_id}";

            $response = Http::withToken($this->accessToken)
            ->asJson()
            ->delete($url);

            return $response;
        } catch (Error | Exception $e) {
            $msg = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();
        }

        $msg = $msg ?? ($response->reason() ?? "");

        Log::channel("vimeo")->error("VIMEO_INTEGRATION: Delete api, Can`t access token", [
            "message" => $msg,
            "line" => $line,
            "file" => $file,
            "client_identifier" => config("vimeo.client_identifier"),
            "client_secrets" => config("vimeo.client_secrets"),
            "body" => []
        ]);

        throw new DeleteException($msg);
    }
}
