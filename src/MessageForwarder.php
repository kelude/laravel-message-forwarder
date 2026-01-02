<?php

namespace Kelude\MessageForwarder;

use Kelude\MessageForwarder\Contracts\HandlesWebhooks;

class MessageForwarder
{
    /**
     * Indicates if MessageForwarder routes will be registered.
     *
     * @var bool
     */
    public static bool $registersRoutes = true;

    /**
     * Register a class / callback that should be used to handle new webhooks.
     *
     * @param  callable|string  $callback
     * @return void
     */
    public static function handleWebhookUsing(callable|string $callback): void
    {
        app()->singleton(HandlesWebhooks::class, $callback);
    }

    /**
     * Configure MessageForwarder to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes(): static
    {
        static::$registersRoutes = false;

        return new static;
    }
}
