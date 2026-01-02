<?php

namespace Kelude\MessageForwarder\Console;

use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use Kelude\MessageForwarder\MessageForwarderServiceProvider;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'message-forwarder:install')]
class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message-forwarder:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the MessageForwarder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->callSilent('vendor:publish', [
            '--provider' => MessageForwarderServiceProvider::class,
        ]);

        $this->registerPaymentServiceProvider();

        $this->components->info('MessageForwarder scaffolding installed successfully.');
    }

    /**
     * Register the MessageForwarder service provider in the application configuration file.
     */
    protected function registerPaymentServiceProvider(): void
    {
        if (! method_exists(ServiceProvider::class, 'addProviderToBootstrapFile')) {
            return;
        }

        ServiceProvider::addProviderToBootstrapFile(\App\Providers\MessageForwarderServiceProvider::class);
    }
}
