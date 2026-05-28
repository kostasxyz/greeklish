<?php

namespace Kostasch\Greeklish;

use Illuminate\Support\Str;

class Greeklish
{
    /**
     * The ordered transliteration rules mapping Greek regex patterns to their
     * latin replacements. Order matters: digraphs and the αυ/ευ/ηυ voicing
     * rules must run before the single-character fallbacks.
     *
     * @return array<string, string>
     */
    protected function expressions(): array
    {
        return [
            '/[αΑ][ιίΙΊ]/u' => 'ai',
            '/[εΕ][ιίΙΊ]/u' => 'ei',
            '/[οΟ][ιίΙΊ]/u' => 'oi',

            '/[αΑ][υύΥΎ]([θΘκΚξΞπΠσςΣτΤφΦχΧψΨ]|\s|$)/u' => 'af$1',
            '/[αΑ][υύΥΎ]/u' => 'av',
            '/[εΕ][υύΥΎ]([θΘκΚξΞπΠσςΣτΤφΦχΧψΨ]|\s|$)/u' => 'ef$1',
            '/[εΕ][υύΥΎ]/u' => 'ev',
            '/[οΟ][υύΥΎ]/u' => 'ou',

            '/[μΜ][πΠ]/u' => 'mp',
            '/[νΝ][τΤ]/u' => 'nt',
            '/[τΤ][σΣ]/u' => 'ts',
            '/[τΤ][ζΖ]/u' => 'tz',
            '/[γΓ][γΓ]/u' => 'ng',
            '/[γΓ][κΚ]/u' => 'gk',
            '/[ηΗ][υύΥΎ]([θΘκΚξΞπΠσςΣτΤφΦχΧψΨ]|\s|$)/u' => 'if$1',
            '/[ηΗ][υύΥΎ]/u' => 'iu',
            '/[υύΥΎ][ιίΙΊ]/u' => 'yi',

            '/[θΘ]/u' => 'th',
            '/[χΧ]/u' => 'ch',
            '/[ψΨ]/u' => 'ps',

            '/[αάΑΆ]/u' => 'a',
            '/[βΒ]/u' => 'v',
            '/[γΓ]/u' => 'g',
            '/[δΔ]/u' => 'd',
            '/[εέΕΈ]/u' => 'e',
            '/[ζΖ]/u' => 'z',
            '/[ηήΗΉ]/u' => 'i',
            '/[ιίϊΐΙΊΪ]/u' => 'i',
            '/[κΚ]/u' => 'k',
            '/[λΛ]/u' => 'l',
            '/[μΜ]/u' => 'm',
            '/[νΝ]/u' => 'n',
            '/[ξΞ]/u' => 'x',
            '/[οόΟΌ]/u' => 'o',
            '/[πΠ]/u' => 'p',
            '/[ρΡ]/u' => 'r',
            '/[σςΣ]/u' => 's',
            '/[τΤ]/u' => 't',
            '/[υύϋΰΥΎΫ]/u' => 'y',
            '/[φΦ]/iu' => 'f',
            '/[ωώ]/iu' => 'o',

            '/[«]/iu' => '',
            '/[»]/iu' => '',
        ];
    }

    /**
     * Transliterate Greek text to its greeklish (latin) equivalent.
     */
    public function make(string $text): string
    {
        $expressions = $this->expressions();

        return preg_replace(array_keys($expressions), array_values($expressions), $text) ?? '';
    }

    /**
     * Transliterate Greek text, optionally stripping one and two letter words.
     */
    public function text(string $text, bool $stopOne = false, bool $stopTwo = false): string
    {
        $text = $this->make($text);

        if ($stopOne) {
            $text = $this->stopOne($text);
        }

        if ($stopTwo) {
            $text = $this->stopTwo($text);
        }

        return $text;
    }

    /**
     * Build a URL friendly slug from Greek text.
     */
    public function slug(string $text, bool $stopOne = true, bool $stopTwo = false): string
    {
        $text = $this->make($text);

        if ($stopOne) {
            $text = $this->stopOne($text);
        }

        if ($stopTwo) {
            $text = $this->stopTwo($text);
        }

        $text = preg_replace(['/&.*?;/', '/\s+/', '/[^A-Za-z0-9_\.\-]/u'], [' ', '-', ''], $text) ?? '';
        $text = filter_var(strtolower($text), FILTER_SANITIZE_URL);

        return Str::slug($text);
    }

    /**
     * Remove standalone one-letter words from the text.
     */
    public function stopOne(string $text): string
    {
        return preg_replace('/\s+\D{1}(?!\S)|(?<!\S)\D{1}\s+/', '', $text) ?? $text;
    }

    /**
     * Remove standalone two-letter words from the text.
     */
    public function stopTwo(string $text): string
    {
        return preg_replace('/\s+\D{2}(?!\S)|(?<!\S)\D{2}\s+/', '', $text) ?? $text;
    }
}
