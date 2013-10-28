# Greeklish

Convert Greek characters to latin and make greeklish slugs.

## Quick Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require": {
		"skapator/greeklish": "1.0.*"
	}
}
```

Run `composer update` to pull down the latest version.

Now open up `app/config/app.php` and add the service provider to your `providers` array.

```php
    'providers' => array(
        ...
        'Skapator\Greeklish\GreeklishServiceProvider',
    )
```

Now add the alias.

```php
    'aliases' => array(
        ...
        'Greeklish' => 'Skapator\Greeklish\Facades\Greeklish',
    )
```


## Usage

-- Make Slug.

```php
    $text = 'Γεια σου Κόσμε';
    Greeklish::make($text)

    Will make:
    `geia-sou-kosme`
```


-- Extra arguments.

```php
    Greeklish::make($text, true)
    // will remove one letter words

    Greeklish::make($text, false, true)
    //will remove two letter words
```

--
