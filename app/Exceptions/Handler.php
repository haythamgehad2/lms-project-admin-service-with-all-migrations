<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        /**
         * Not FoundHttp
         */
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "code"=> 404,
                    "errors"=>[
                        "Record not found"
                    ],
                    "data"=> [],
                    "messages"=> [],
                    "meta"=> []
                ], 404);
            }
        });

        /**
         * Model NotFound
         */
        $this->renderable(function (RouteNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "code"=> 404,
                    "errors"=>[
                        "Resource not found"
                    ],
                    "data"=> [],
                    "messages"=> [],
                    "meta"=> []
                ], 404);
            }
        });

         /**
         * Model NotFound
         */
        $this->renderable(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "code"=> 404,
                    "errors"=>[
                        "Resource not found"
                    ],
                    "data"=> [],
                    "messages"=> [],
                    "meta"=> []
                ], 404);
            }
        });

         /**
         * Authorization NotFound
         */
        $this->renderable(function (AuthorizationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    "code"=> 403,
                    "errors"=>[
                        "Not authorized,not have Permssion For This"
                    ],
                    "data"=> [],
                    "messages"=> [],
                    "meta"=> []
                ], 403);
            }
        });

        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                        "code"=> 401,
                        "errors"=>[
                            "Unauthenticated"
                        ],
                        "data"=> [],
                        "messages"=> [],
                        "meta"=> []
                ], 401);
            }
        });
    }
}
