<?php
namespace App\Integrations\Vimeo;

use App\Integrations\Vimeo\Exceptions\AuthException;
use Error;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Auth {
    private const endpoint = "/oauth/authorize/client";

    public function getUploadAccessToken() : string {
        return $this->getAccessToken("upload");
    }

    private function getAccessToken(string $scope) : string {
        $msg = "";
        $line = "";
        $file = "";

        try {
            $response = Http::withBasicAuth(
                config("vimeo.client_identifier"),
                config("vimeo.client_secrets")
            )
            ->accept("application/vnd.vimeo.*+json;version=3.4")
            ->asJson()
            ->post(
                config("vimeo.api_url") . self::endpoint,
                ["grant_type" => "device_grant", "scope" => $scope]
            );

            if ($token = $response->json("access_token")) return $token;
        } catch (Error | Exception $e) {
            $msg = $e->getMessage();
            $line = $e->getLine();
            $file = $e->getFile();
        }

        $msg = $msg ?? ($response->reason() ?? "");

        Log::channel("vimeo")->error("VIMEO_INTEGRATION: Auth api, Can`t access token", [
            "message" => $msg,
            "line" => $line,
            "file" => $file,
            "client_identifier" => config("vimeo.client_identifier"),
            "client_secrets" => config("vimeo.client_secrets"),
            "body" => ["grant_type" => "client_credentials", "scope" => "upload"]
        ]);

        throw new AuthException($msg);
    }
}
