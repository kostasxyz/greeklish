# Greeklish

Convert Greek characters to latin and make greeklish slugs.

## Quick Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require": {
		"skapator/greeklish": "dev-master"
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
    Greeklish::slug($text)

    Will make:
    `geia-sou-kosme`
```


-- Make a greeklish text.

```php
    $text = 'Γεια σου Κόσμε';
    Greeklish::text($text)

    Will make:
    `Geia sou kosme`
```


-- Extra arguments.

```php
    Greeklish::text($text, true)
    // will remove one letter words

    Greeklish::slug($text, false, true)
    //will remove two letter words
```

--
