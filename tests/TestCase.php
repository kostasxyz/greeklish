<?php

namespace Kostasch\Greeklish\Tests;

use Kostasch\Greeklish\Facades\Greeklish;
use Kostasch\Greeklish\GreeklishServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            GreeklishServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Greeklish' => Greeklish::class,
        ];
    }
}
