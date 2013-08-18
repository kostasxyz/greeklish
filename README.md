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

-- Make Slug.

    `$text = 'Γεια σου Κόσμε';`
    `Greeklish::make($text)`

    Will make:
    `geia-sou-kosme`


-- Extra arguments.

    `Greeklish::make($text, true)`
    will remove one letter words

    `Greeklish::make($text, false, true)`
    will remove two letter words

--