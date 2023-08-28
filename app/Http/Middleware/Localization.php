<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Localization
{

        /**
        * Handle an incoming request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \Closure  $next
        * @return mixed
        */
        public function handle(Request $request, Closure $next)
        {
            if ($request->header('locale') === 'en') {
                App::setLocale($request->header('locale'));
            }else{
                App::setLocale('ar');
            }
            return $next($request);
        }

}
