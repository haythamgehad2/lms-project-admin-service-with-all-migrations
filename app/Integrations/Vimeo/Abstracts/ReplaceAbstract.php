<?php
namespace App\Integrations\Vimeo\Abstracts;

use Error;
use Exception;
use App\Models\VideoBank;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Integrations\Vimeo\Exceptions\UploadException;
use App\Integrations\Vimeo\Exceptions\VimeoVideoHasUploadException;
use App\Models\VimeoVideo;

abstract class ReplaceAbstract {
    protected const endpoint = "/videos/::video_id::/versions";

    protected string $accessToken;

    public function __construct(
        protected VideoBank $videoBank
    ) {
        $this->accessToken = config("vimeo.api_token");
    }

    protected abstract function getFirstVimeo() : VimeoVideo | null;
    protected abstract function getVideoSizeInBytes() : int | null;
    protected abstract function getVideoFullUrl() : string | null;

    public function replacePullUpload() : Response {
        $firstVimeo = $this->getFirstVimeo();

        if (!$firstVimeo) throw new VimeoVideoHasUploadException;

        $msg = "";
        $line = "";
        $file = "";

        $requestBody = [
            "file_name" => $firstVimeo->vimeo_response["name"] ?? "",
            "upload" => [
                "status" => "in_progress",
                "approach" => "pull",
                "size" => $this->getVideoSizeInBytes(),
                "link" => $this->getVideoFullUrl(),
            ],
        ];

        try {
            $url = config("vimeo.api_url") . self::endpoint;
            $url = Str::replace("::video_id::", $firstVimeo->vimeo_video_id, $url);

            $response = Http::withToken($this->accessToken)
            ->accept("application/vnd.vimeo.*+json;version=3.4")
            ->asJson()
            ->post($url, $requestBody);

            return $response;
        } catch (Error | Exception $e) {
            $msg = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();
        }

        $msg = $msg ?? ($response->reason() ?? "");

        Log::channel("vimeo")->error("VIMEO_INTEGRATION: Replace Pull Upload api, Can`t access token", [
            "message" => $msg,
            "line" => $line,
            "file" => $file,
            "client_identifier" => config("vimeo.client_identifier"),
            "client_secrets" => config("vimeo.client_secrets"),
            "body" => $requestBody
        ]);

        throw new UploadException($msg);
    }
}
