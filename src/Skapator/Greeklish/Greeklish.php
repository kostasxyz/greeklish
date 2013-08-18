<?php namespace Skapator\Greeklish;

class Greeklish {

    /**
     * Greeglish
     *
     * @param string $text - the greek text
     * @param bool $stop_one - if true removes one letter words
     * @param bool $stop_two - if true removes two letter words
     * @return string $text
     * @author Skapator
     * @access public
     */
    public function make($text, $stop_one = false, $stop_two = false) {

        $expressions = array(
            '/[αΑ][ιίΙΊ]/u' => 'e',
            '/[οΟΕε][ιίΙΊ]/u' => 'i',

            '/[αΑ][υύΥΎ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'af$1',
            '/[αΑ][υύΥΎ]/u' => 'av',
            '/[εΕ][υύΥΎ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'ef$1',
            '/[εΕ][υύΥΎ]/u' => 'ev',
            '/[οΟ][υύΥΎ]/u' => 'ou',

            //'/(^|\s)[μΜ][πΠ]/u' => '$1b',
            //'/[μΜ][πΠ](\s|$)/u' => 'b$1',
            '/[μΜ][πΠ]/u' => 'mp',
            '/[νΝ][τΤ]/u' => 'nt',
            '/[τΤ][σΣ]/u' => 'ts',
            '/[τΤ][ζΖ]/u' => 'tz',
            '/[γΓ][γΓ]/u' => 'ng',
            '/[γΓ][κΚ]/u' => 'gk',
            '/[ηΗ][υΥ]([θΘκΚξΞπΠσςΣτTφΡχΧψΨ]|\s|$)/u' => 'if$1',
            '/[ηΗ][υΥ]/u' => 'iu',

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
            '/[ιίϊΙΊΪ]/u' => 'i',
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
            '/[υύϋΥΎΫ]/u' => 'i',
            '/[φΦ]/iu' => 'f',
            '/[ωώ]/iu' => 'o',

            '/[«]/iu' => '',
            '/[»]/iu' => ''
        );

        $text = preg_replace( array_keys($expressions), array_values($expressions), $text );

        if ($stop_one == true)
        {
            $text = preg_replace('/\s+\D{1}(?!\S)|(?<!\S)\D{1}\s+/', '', $text);
        }

        if ($stop_two == true )
        {
            $text = preg_replace('/\s+\D{2}(?!\S)|(?<!\S)\D{2}\s+/', '', $text);
        }

        $text = preg_replace( '/\s+/', '-', $text );

        $text = preg_replace( '/[^a-z0-9_\.\-]/u', '', $text );

        return $text;
    }

}