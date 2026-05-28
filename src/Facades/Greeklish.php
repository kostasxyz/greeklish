<?php

namespace Kostasch\Greeklish\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string make(string $text)
 * @method static string text(string $text, bool $stopOne = false, bool $stopTwo = false)
 * @method static string slug(string $text, bool $stopOne = true, bool $stopTwo = false)
 * @method static string stopOne(string $text)
 * @method static string stopTwo(string $text)
 *
 * @see \Kostasch\Greeklish\Greeklish
 */
class Greeklish extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'greeklish';
    }
}
