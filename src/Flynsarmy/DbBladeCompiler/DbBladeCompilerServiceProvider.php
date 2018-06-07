<?php namespace Flynsarmy\DbBladeCompiler;

use Illuminate\Support\ServiceProvider;

class DbBladeCompilerServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $config_path = __DIR__ . '/../../../config/db-blade-compiler.php';
        $this->publishes([$config_path => config_path('db-blade-compiler.php')], 'config');

        $views_path = __DIR__ . '/../../../config/.gitkeep';
        $this->publishes([$views_path => storage_path('app/db-blade-compiler/views/.gitkeep')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config_path = __DIR__ . '/../../../config/db-blade-compiler.php';
        $this->mergeConfigFrom($config_path, 'db-blade-compiler');

        $this->app->singleton(DbView::class, function($app) {
            return new DbView($app->make('config'), new DbBladeCompilerEngine($app->make(DbBladeCompiler::class)));
        });

        $this->app->alias(DbView::class, 'dbview');

        $this->app->bind(DbBladeCompiler::class, function($app) {
            $config = $app->make('config');

            return new DbBladeCompiler($app['files'], $config->get('db-blade-compiler.storage_path'), $config);
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
