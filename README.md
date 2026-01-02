# Laravel Message Forwarder

A Laravel package to easily handle incoming MessageForwarder webhooks.

## Installation

You can install the package via composer:

```bash
composer require kelude/laravel-message-forwarder:dev-main
```

After installing, run the install command to scaffold the necessary files:

```bash
php artisan message-forwarder:install
```

This command will:
1. Publish the configuration file to `config/message_forwarder.php`.
2. Publish the webhook handler action to `app/Actions/MessageForwarder/HandleWebhook.php`.
3. Publish and register the `MessageForwarderServiceProvider` in your application.

## Usage

### Handling Webhooks

The package uses an Action class to handle incoming webhooks. After installation, you can find the handler at `app/Actions/MessageForwarder/HandleWebhook.php`.

You should modify the `handle` method in this class to implement your custom logic (e.g., saving the messages to the database, forwarding it to Telegram/Slack, etc.).

```php
<?php

namespace App\Actions\MessageForwarder;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;
use Kelude\MessageForwarder\Contracts\HandlesWebhooks;
use Symfony\Component\HttpFoundation\Response;

class HandleWebhook implements HandlesWebhooks
{
    /**
     * Handle a webhook call.
     *
     * @param  Request  $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        // Log::info('Webhook Received', $request->all());

        // Your logic here...

        return new Response('Webhook Handled', Response::HTTP_OK);
    }
}
```

### Configuration

You can configure the package in `config/message_forwarder.php`.

#### Route Prefix
By default, the webhook route is available at `/message-forwarder/webhook`. You can change the prefix in the config or via `.env`:

```env
MESSAGE_FORWARDER_PREFIX=custom-prefix
```

#### Middleware
You can add custom middleware to the webhook route in `config/message_forwarder.php`:

```php
'middleware' => ['api'],
```

### Security: Webhook Signature Verification

To ensure that the webhook requests are coming from a trusted source, you should configure a webhook secret.

1. Set the secret in your `.env` file:
   ```env
   MESSAGE_FORWARDER_WEBHOOK_SECRET=your-secret-key
   ```

2. The package will automatically verify the signature included in the request body (`sign` parameter) using this secret.

If the secret is not set, signature verification is skipped (not recommended for production).

## Testing

You can run the tests with:

```bash
vendor/bin/pest
```

## License

The MIT License (MIT).
