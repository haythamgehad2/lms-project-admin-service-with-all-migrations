<?php
namespace App\Integrations\Vimeo\Abstracts;

use App\Integrations\Vimeo\Exceptions\UploadException;
use App\Models\VideoBank;
use Error;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class UploadAbstract {
    protected const endpoint = "/me/videos";

    protected string $accessToken;

    public function __construct(
        protected VideoBank $videoBank
    ) {
        $this->accessToken = config("vimeo.api_token");
    }

    protected abstract function getVideoSizeInBytes() : int | null;
    protected abstract function getVideoFullUrl() : string | null;

    public function pullUpload() : Response {
        $msg = "";
        $line = "";
        $file = "";

        $requestBody = [
            "upload" => [
                "approach" => "pull",
                "size" => $this->getVideoSizeInBytes(),//$this->videoBank->video_size_bytes,
                "link" => $this->getVideoFullUrl(),//$this->videoBank->video_full_url,
            ],
            "privacy" => [
                "download" => false,
                "view" => "unlisted",
                "embed" => "whitelist"
            ],
            "embed" => [
                "buttons" => [
                    "fullscreen" => true
                ],
                "playbar" => true,
                "volume" => true,
            ],
            "embed_domains" => [
                env("APP_URL",'https://jeeladmin.suredemos.com'),
                env("STUDENT_APP_URL",'https://jeelstudent.suredemos.com')
            ]
        ];

        try {
            $response = Http::withToken($this->accessToken)
            ->accept("application/vnd.vimeo.*+json;version=3.4")
            ->asJson()
            ->post(config("vimeo.api_url") . self::endpoint, $requestBody);

            return $response;
        } catch (Error | Exception $e) {
            $msg = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();
        }

        $msg = $msg ?? ($response->reason() ?? "");

        Log::channel("vimeo")->error("VIMEO_INTEGRATION: Pull Upload api, Can`t access token", [
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
