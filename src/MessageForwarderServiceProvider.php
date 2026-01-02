<?php

namespace Kelude\MessageForwarder;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MessageForwarderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/message_forwarder.php', 'message_forwarder');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configurePublishing();
        $this->configureRoutes();
        $this->registerCommands();
    }

    /**
     * Configure the publishable resources offered by the package.
     *
     * @return void
     */
    protected function configurePublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../stubs/message_forwarder.php' => $this->app->configPath('message_forwarder.php'),
            ], 'message-forwarder-config');

            $this->publishes([
                __DIR__.'/../stubs/HandleWebhook.php' => $this->app->basePath('app/Actions/MessageForwarder/HandleWebhook.php'),
                __DIR__ . '/../stubs/MessageForwarderServiceProvider.php' => $this->app->basePath('app/Providers/MessageForwarderServiceProvider.php'),
            ], 'message-forwarder-support');
        }
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes(): void
    {
        if (MessageForwarder::$registersRoutes) {
            Route::group([
                'domain' => config('message_forwarder.domain', null),
                'prefix' => config('message_forwarder.prefix'),
                'as' => 'message_forwarder.',
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
            });
        }
    }

    /**
     * Register the package's commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
            ]);
        }
    }
}
