<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/user.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/country.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/learningpath.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/questionTypes.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/bloomCategory.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/languageSkill.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/languageMethod.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/questionDifficulty.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/enrollment.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/student.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/question.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/package.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/schoolGroup.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/schoolType.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/school.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/level.php'));


            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/videobank.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/missions.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/quizzes.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/peperWorks.php'));


            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/term.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/class.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/theme.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/role.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/permission.php'));

            Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/auth.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/rewardActions.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/jeelLevelXp.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/jeelGemPrice.php'));

            Route::prefix('api')
            ->middleware(['api','auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/studentActionHistory.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
