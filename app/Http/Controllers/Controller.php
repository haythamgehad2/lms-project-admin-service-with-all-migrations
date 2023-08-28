<?php

namespace App\Http\Controllers;
use App\Responses\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{

    public function __construct (Request $request) {
        $lang = $request->header('locale');
        if ($lang != null) App::setLocale($lang);
        else App::setLocale('en');

    }

    use AuthorizesRequests, ValidatesRequests;
}
