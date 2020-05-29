<?php

namespace Binarcode\LaravelStatelessSession;

use Binarcode\LaravelStatelessSession\Http\Controllers\CsrfHeaderController;
use Binarcode\LaravelStatelessSession\Http\Middleware\StatelessStartSession;
use Binarcode\LaravelStatelessSession\Http\Middleware\StatelessVerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaravelStatelessSessionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->defineRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('stateless.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerSessionManager();

        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'stateless');

        $this->app->singleton('laravel-stateless-session', function () {
            return new LaravelStatelessSession;
        });
    }

    /**
     * We have to override this singleton because we want to pass
     * the name to the session header from another configuration key:
     * session.header
     */
    protected function registerSessionManager()
    {
        $this->app->singleton('session', function ($app) {
            return new SessionManager($app);
        });
    }

    protected function defineRoutes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::group(['prefix' => config('stateless.prefix', 'api'), 'middleware' => config('stateless.middleware'),], function () {
            Route::get(
                '/csrf-header',
                CsrfHeaderController::class . '@show'
            )->middleware([
                StatelessStartSession::class,
                StatelessVerifyCsrfToken::class,
            ]);
        });
    }
}
