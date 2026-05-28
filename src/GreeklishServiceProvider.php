<?php

namespace Kostasch\Greeklish;

use Illuminate\Support\ServiceProvider;

class GreeklishServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('greeklish', fn () => new Greeklish);

        $this->app->alias('greeklish', Greeklish::class);
    }
}
