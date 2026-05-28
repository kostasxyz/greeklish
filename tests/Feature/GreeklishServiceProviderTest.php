<?php

use Kostasch\Greeklish\Facades\Greeklish as GreeklishFacade;
use Kostasch\Greeklish\Greeklish;
use Kostasch\Greeklish\GreeklishServiceProvider;

it('registers the package service provider', function () {
    expect($this->app->getProvider(GreeklishServiceProvider::class))
        ->toBeInstanceOf(GreeklishServiceProvider::class);
});

it('binds a singleton resolvable via the "greeklish" key', function () {
    expect(app('greeklish'))->toBeInstanceOf(Greeklish::class)
        ->and(app('greeklish'))->toBe(app('greeklish'));
});

it('resolves the class through its container alias', function () {
    expect(app(Greeklish::class))->toBeInstanceOf(Greeklish::class);
});

it('resolves the facade root from the container', function () {
    expect(GreeklishFacade::getFacadeRoot())->toBeInstanceOf(Greeklish::class);
});

it('transliterates through the facade', function () {
    expect(GreeklishFacade::slug('Γεια σου Κόσμε'))->toBe('geia-sou-kosme')
        ->and(GreeklishFacade::text('Γεια σου Κόσμε'))->toBe('geia sou kosme')
        ->and(GreeklishFacade::make('αυτός'))->toBe('aftos');
});
