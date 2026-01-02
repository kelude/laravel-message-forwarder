<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            \Kelude\MessageForwarder\MessageForwarderServiceProvider::class,
        ];
    }
}
