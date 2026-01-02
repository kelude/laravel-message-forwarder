<?php

use Illuminate\Support\Facades\Route;
use Kelude\MessageForwarder\Http\Controllers\WebhookController;

Route::group(['middleware' => config('message_forwarder.middleware')], function () {
    Route::post('webhook', [WebhookController::class, 'handle'])->name('webhook');
});
