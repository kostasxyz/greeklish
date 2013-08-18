# Greeklish

Convert Greek characters to latin and make greeklish slugs.

Add `skapator/greeklish` to `composer.json`.

    "skapator/greeklish": "dev-master"

Run `composer update` to pull down the latest version.

Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
        'Skapator\Greeklish\GreeklishServicessProvider',
    )

Now add the alias.

    'aliases' => array(
        'Greeklish' => 'Skapator\Greeklish\Facades\Greeklish',
    )


## Usage

1. Make Slug.

    `$text = 'Γεια σου Κόσμε';`
    `Greeklish::slug($text)`

    Will make:
    `geia-sou-kosme`

2. Just greeklish

    `$text = 'Γεια σου Κόσμε';`
    `Greeklish::text($text)`

    Will make:
    `Geia sou Kosme`