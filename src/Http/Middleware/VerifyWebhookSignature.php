<?php

namespace Kelude\MessageForwarder\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kelude\MessageForwarder\Exceptions\SignatureVerificationException;
use Kelude\MessageForwarder\WebhookSignature;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VerifyWebhookSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            WebhookSignature::verifyPayload(
                $request->getContent(),
                config('sms_forwarder.webhook.secret'),
                config('sms_forwarder.webhook.tolerance')
            );
        } catch (SignatureVerificationException $exception) {
            throw new AccessDeniedHttpException($exception->getMessage(), $exception);
        }

        return $next($request);
    }
}
