# Greeklish

Convert Greek text to latin characters and generate clean, URL-friendly slugs for Laravel.

Vowels follow the **ELOT 743 / ISO 843** letter-preserving rules (`αι→ai`, `ει→ei`, `οι→oi`, `υι→yi`, `υ→y`), with the `αυ`/`ευ`/`ηυ` voicing rules (`αυτός → aftos`, `ευρώ → evro`), accent and diaeresis stripping, and guillemet removal. Greek names transcribe as on a passport — `Αικατερίνη → aikaterini`, `Ειρήνη → eirini`, `Οικονόμου → oikonomou`.

## Requirements

- PHP 8.2+
- Laravel 12 or 13

## Installation

```bash
composer require kostasch/greeklish
```

The service provider and the `Greeklish` facade are registered automatically through Laravel package discovery — no configuration required.

## Usage

```php
use Kostasch\Greeklish\Facades\Greeklish;

Greeklish::make('Γεια σου Κόσμε');   // "geia sou kosme"
Greeklish::text('Γεια σου Κόσμε');   // "geia sou kosme"
Greeklish::slug('Γεια σου Κόσμε');   // "geia-sou-kosme"
```

### `make()`

Raw transliteration of Greek to latin, leaving spacing and punctuation in place.

```php
Greeklish::make('Καλημέρα!'); // "kalimera!"
```

### `text()`

Transliteration with optional stripping of short words.

```php
Greeklish::text('ο σκύλος μου');           // "o skylos mou"
Greeklish::text('ο σκύλος μου', true);      // "skylos mou"  (drops one-letter words)
Greeklish::text('το σπίτι', false, true);   // "spiti"       (drops two-letter words)
```

### `slug()`

Builds a URL-friendly slug. `stopOne` defaults to `true`, so one-letter words are dropped.

```php
Greeklish::slug('Άρθρο για την Ελλάδα'); // "arthro-gia-tin-ellada"
Greeklish::slug('ο σκύλος μου');          // "skylos-mou"
Greeklish::slug('ο σκύλος μου', false);   // "o-skylos-mou"
```

### Without the facade

The class is bound in the container and can be resolved or injected directly:

```php
use Kostasch\Greeklish\Greeklish;

public function store(Greeklish $greeklish): void
{
    $slug = $greeklish->slug($request->title);
}
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [LICENSE.md](LICENSE.md) for more information.
