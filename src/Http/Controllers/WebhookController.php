<?php

namespace Kelude\MessageForwarder\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kelude\MessageForwarder\Contracts\HandlesWebhooks;
use Kelude\MessageForwarder\Events\WebhookHandled;
use Kelude\MessageForwarder\Events\WebhookReceived;
use Kelude\MessageForwarder\Http\Middleware\VerifyWebhookSignature;

class WebhookController extends Controller
{
    public function __construct()
    {
        if (config('sms_forwarder.webhook.secret')) {
            $this->middleware(VerifyWebhookSignature::class);
        }
    }

    /**
     * Handle a MessageForwarder webhook call.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Kelude\MessageForwarder\Contracts\HandlesWebhooks  $handler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, HandlesWebhooks $handler)
    {
        WebhookReceived::dispatch($request);

        $response = $handler->handle($request);

        WebhookHandled::dispatch($request);

        return $response;
    }
}
