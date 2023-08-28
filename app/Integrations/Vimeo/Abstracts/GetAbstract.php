<?php
namespace App\Integrations\Vimeo\Abstracts;

use Error;
use Exception;
use App\Models\VideoBank;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Integrations\Vimeo\Exceptions\VimeoVideoHasUploadException;
use App\Models\VimeoVideo;

abstract class GetAbstract {
    public function __construct(
        protected VideoBank $videoBank
    ) {}

    protected abstract function getFirstVimeo() : VimeoVideo | null;

    public function get() : Response | null {
        $firstVimeo = $this->getFirstVimeo();

        if (!$firstVimeo) throw new VimeoVideoHasUploadException;

        $msg = "";
        $line = "";
        $file = "";

        try {
            $response = Http::withToken(config("vimeo.api_token"))
                ->accept("application/vnd.vimeo.*+json;version=3.4")
                ->asJson()
                ->get(config("vimeo.api_url") . $firstVimeo->vimeo_response["uri"]);
            return $response;
        } catch (Error | Exception $e) {
            $msg = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();
        }

        $msg = $msg ?? ($response->reason() ?? "");

        Log::channel("vimeo")->error("VIMEO_INTEGRATION: Get Video api, Can`t access token", [
            "message" => $msg,
            "line" => $line,
            "file" => $file,
            "client_identifier" => config("vimeo.client_identifier"),
            "client_secrets" => config("vimeo.client_secrets"),
            "body" => []
        ]);
        return null;
    }
}
