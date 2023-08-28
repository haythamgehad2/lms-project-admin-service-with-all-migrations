<?php

return [
    "client_identifier" => env("VIMEO_CLIENT_IDENTIFIER", "d87c5b8b49a7c99a874d3bafe9e76027f7d347ea"),
    "client_secrets" => env(
        "VIMEO_CLIENT_SECRETS",
        "s/t4u5ueaEf79z8/ITRLfqpVvHwrhIQX82ccKv3X6WIqSJ/chRTnlFfVcJlKZHRj/c7LyDwLUhtCbmwpImPQtS+f2H5cTwsJq+h+nIrBr89GEwD4k6EBlyTpy3giG/Qh"
    ),
    "api_url" => env("VIMEO_API_URL", "https://api.vimeo.com"),
    "api_token" => env("VIMEO_API_TOKEN", "cadf027bbdefd92fc0a28372fb4b8b27"),
];
