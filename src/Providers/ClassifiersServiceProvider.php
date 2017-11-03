<?php

namespace InetStudio\Classifiers\Providers;

use Illuminate\Support\ServiceProvider;
use InetStudio\Classifiers\Console\Commands\SetupCommand;

class ClassifiersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Register Classifiers's console commands.
     *
     * @return void
     */
    protected function registerConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
            ]);
        }
    }

    /**
     * Setup the resource publishing groups for Classifiers.
     *
     * @return void
     */
    protected function registerPublishes()
    {
        $this->publishes([
            __DIR__.'/../../config/classifiers.php' => config_path('classifiers.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateClassifiersTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../../database/migrations/create_classifiers_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_classifiers_tables.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Register Classifiers's routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Register Classifiers's views.
     *
     * @return void
     */
    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.classifiers');
    }
}
