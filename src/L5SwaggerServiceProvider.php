<?php

namespace L5Swagger;

use Illuminate\Support\ServiceProvider;
use L5Swagger\Console\GenerateDocsCommand;

class L5SwaggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

        $viewPath = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($viewPath, 'l5-swagger');

        // Publish a config file
        $configPath = __DIR__.'/../config/l5-swagger.php';
        $this->publishes([
            $configPath => config_path('l5-swagger.php'),
        ], 'config');

        //Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => config('l5-swagger.paths.views'),
        ], 'views');

        //Include routes
        \Route::group(['namespace' => 'L5Swagger'], function($router) {
            $projects = config("l5-swagger.projects") ;
            require __DIR__ .'/routes.php';
        });

        //Register commands
        $this->commands([GenerateDocsCommand::class]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/l5-swagger.php';
        $this->mergeConfigFrom($configPath, 'l5-swagger');

        $this->app->singleton('command.l5-swagger.generate', function() {
            return new GenerateDocsCommand();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.l5-swagger.generate',
        ];
    }

    public function loadProjectConfig($project)
    {
        // Publish a config file
        $configPath = __DIR__ . "/../app/{$project}/config/l5-swagger.php";
        $this->publishes([
            $configPath => config_path('l5-swagger.php'),
        ], 'config');
    }
}
