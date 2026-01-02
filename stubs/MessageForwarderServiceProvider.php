<?php

namespace App\Providers;

use App\Actions\MessageForwarder\HandleWebhook;
use Illuminate\Support\ServiceProvider;
use Kelude\MessageForwarder\MessageForwarder;

class MessageForwarderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        MessageForwarder::handleWebhookUsing(HandleWebhook::class);
    }
}
