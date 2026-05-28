<?php

use Kostasch\Greeklish\Greeklish;

beforeEach(function () {
    $this->greeklish = new Greeklish;
});

describe('make() vowel digraphs', function () {
    // ELOT 743 keeps the vowel letters: αι→ai, ει→ei, οι→oi, υι→yi (not phonetic).
    it('transliterates two-vowel combinations', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'αι → ai' => ['αι', 'ai'],
        'ΑΙ → ai (uppercase)' => ['ΑΙ', 'ai'],
        'αί → ai (accented)' => ['αί', 'ai'],
        'ει → ei' => ['ει', 'ei'],
        'ΕΙ → ei (uppercase)' => ['ΕΙ', 'ei'],
        'οι → oi' => ['οι', 'oi'],
        'ΟΙ → oi (uppercase)' => ['ΟΙ', 'oi'],
        'υι → yi' => ['υι', 'yi'],
        'ΥΙ → yi (uppercase)' => ['ΥΙ', 'yi'],
        'ου → ou' => ['ου', 'ou'],
        'σου → sou' => ['σου', 'sou'],
    ]);
});

describe('make() αυ/ευ/ηυ voicing', function () {
    it('voices to "f" before voiceless consonants and word boundaries', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'αυτός → aftos (before τ)' => ['αυτός', 'aftos'],
        'ναυ → naf (end of word)' => ['ναυ', 'naf'],
        'ναυς → nafs (before ς)' => ['ναυς', 'nafs'],
        'ευτυχία → eftychia (before τ)' => ['ευτυχία', 'eftychia'],
        'εύκολο → efkolo (before κ)' => ['εύκολο', 'efkolo'],
        'ηυ → if (end of word)' => ['ηυ', 'if'],
    ]);

    it('voices to "v"/"u" before voiced sounds', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'αύριο → avrio (before ρ)' => ['αύριο', 'avrio'],
        'αυγό → avgo (before γ)' => ['αυγό', 'avgo'],
        'ευρώ → evro (before ρ)' => ['ευρώ', 'evro'],
        'Ευρώπη → evropi' => ['Ευρώπη', 'evropi'],
    ]);

    // Regression guard: the original 2014 table used Latin "T" (U+0054) and Greek
    // "Ρ" (rho, U+03A1) instead of Greek "Τ" (tau, U+03A4) and "Φ" (phi, U+03A6),
    // so UPPERCASE digraphs failed to voice. These assertions fail on that code.
    it('voices uppercase digraphs before uppercase Τ and Φ', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'ΑΥΤΟΣ → aftos' => ['ΑΥΤΟΣ', 'aftos'],
        'ΕΥΤΥΧΗΣ → eftychis' => ['ΕΥΤΥΧΗΣ', 'eftychis'],
        'ΗΥΤ → ift' => ['ΗΥΤ', 'ift'],
        'ΑΥΦ → aff' => ['ΑΥΦ', 'aff'],
        'ΕΥΦ → eff' => ['ΕΥΦ', 'eff'],
        'ΗΥΦ → iff' => ['ΗΥΦ', 'iff'],
    ]);

    // Regression guard: the ηυ rules originally used [υΥ], omitting accented ύ/Ύ,
    // so an accented ηυ diphthong (the common case, e.g. ηύξησε) fell through to
    // single letters and produced "ii" instead of voicing to "if"/"iu".
    it('voices accented ηυ diphthongs', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'ηύ → if (end of word)' => ['ηύ', 'if'],
        'ΗΎ → if (end of word)' => ['ΗΎ', 'if'],
        'ηύξησε → ifxise (before ξ)' => ['ηύξησε', 'ifxise'],
        'διηύθυνε → diifthyne (before θ)' => ['διηύθυνε', 'diifthyne'],
        'ηύρ → iur (before ρ)' => ['ηύρ', 'iur'],
    ]);
});

describe('make() consonant digraphs', function () {
    it('transliterates consonant clusters', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'μπύρα → mpyra' => ['μπύρα', 'mpyra'],
        'ντομάτα → ntomata' => ['ντομάτα', 'ntomata'],
        'τσάι → tsai' => ['τσάι', 'tsai'],
        'τζατζίκι → tzatziki' => ['τζατζίκι', 'tzatziki'],
        'άγγελος → angelos (γγ)' => ['άγγελος', 'angelos'],
        'γκολ → gkol' => ['γκολ', 'gkol'],
    ]);
});

describe('make() θ/χ/ψ multigraphs', function () {
    it('transliterates θ, χ and ψ', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'θάλασσα → thalassa' => ['θάλασσα', 'thalassa'],
        'Θεός → theos' => ['Θεός', 'theos'],
        'χαρά → chara' => ['χαρά', 'chara'],
        'Χίος → chios' => ['Χίος', 'chios'],
        'ψωμί → psomi' => ['ψωμί', 'psomi'],
        'Ψαρά → psara' => ['Ψαρά', 'psara'],
    ]);
});

describe('make() accent and diaeresis stripping', function () {
    it('strips tonos and dialytika from vowels', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'ά → a' => ['ά', 'a'],
        'έ → e' => ['έ', 'e'],
        'ή → i' => ['ή', 'i'],
        'ί → i' => ['ί', 'i'],
        'ό → o' => ['ό', 'o'],
        'ύ → y' => ['ύ', 'y'],
        'ώ → o' => ['ώ', 'o'],
        'ϊ → i' => ['ϊ', 'i'],
        'ϋ → y' => ['ϋ', 'y'],
        'ΐ → i (dialytika+tonos)' => ['ΐ', 'i'],
        'ΰ → y (dialytika+tonos)' => ['ΰ', 'y'],
        'Ά → a' => ['Ά', 'a'],
        'Ή → i' => ['Ή', 'i'],
        'Ώ → o' => ['Ώ', 'o'],
    ]);

    // Regression guard: ΐ (U+0390) and ΰ (U+03B0) were absent from the iota/upsilon
    // classes, so words carrying them leaked raw Greek into the output.
    it('transliterates words containing dialytika+tonos vowels', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'πρωτεΐνη → proteini' => ['πρωτεΐνη', 'proteini'],
        'ναΰς → nays' => ['ναΰς', 'nays'],
    ]);
});

describe('make() single letters', function () {
    it('transliterates every lowercase letter', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        ['α', 'a'], ['β', 'v'], ['γ', 'g'], ['δ', 'd'], ['ε', 'e'],
        ['ζ', 'z'], ['η', 'i'], ['θ', 'th'], ['ι', 'i'], ['κ', 'k'],
        ['λ', 'l'], ['μ', 'm'], ['ν', 'n'], ['ξ', 'x'], ['ο', 'o'],
        ['π', 'p'], ['ρ', 'r'], ['σ', 's'], ['ς', 's'], ['τ', 't'],
        ['υ', 'y'], ['φ', 'f'], ['χ', 'ch'], ['ψ', 'ps'], ['ω', 'o'],
    ]);

    it('transliterates every uppercase letter', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        ['Α', 'a'], ['Β', 'v'], ['Γ', 'g'], ['Δ', 'd'], ['Ε', 'e'],
        ['Ζ', 'z'], ['Η', 'i'], ['Θ', 'th'], ['Ι', 'i'], ['Κ', 'k'],
        ['Λ', 'l'], ['Μ', 'm'], ['Ν', 'n'], ['Ξ', 'x'], ['Ο', 'o'],
        ['Π', 'p'], ['Ρ', 'r'], ['Σ', 's'], ['Τ', 't'], ['Υ', 'y'],
        ['Φ', 'f'], ['Χ', 'ch'], ['Ψ', 'ps'], ['Ω', 'o'],
    ]);
});

// ELOT 743 / ISO 843 conformance for the letter-preserving vowel rules.
// These exercise real Greek names against their official passport transcription.
describe('ELOT 743 vowel conformance', function () {
    it('matches the official ELOT 743 transcription', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'Αικατερίνη → aikaterini (αι)' => ['Αικατερίνη', 'aikaterini'],
        'Ειρήνη → eirini (ει)' => ['Ειρήνη', 'eirini'],
        'Οικονόμου → oikonomou (οι, ου)' => ['Οικονόμου', 'oikonomou'],
        'Υγεία → ygeia (υ, ει)' => ['Υγεία', 'ygeia'],
        'υιός → yios (υι)' => ['υιός', 'yios'],
        'μύλος → mylos (υ)' => ['μύλος', 'mylos'],
        'σύστημα → systima (υ)' => ['σύστημα', 'systima'],
        'Παρασκευή → paraskevi (ευ before ή)' => ['Παρασκευή', 'paraskevi'],
        'Ελευθερία → eleftheria (ευ before θ)' => ['Ελευθερία', 'eleftheria'],
        'προϋπολογισμός → proypologismos (diaeresis breaks ου)' => ['προϋπολογισμός', 'proypologismos'],
    ]);
});

// Full-sentence ELOT 743 cases. These cover broken diphthongs (άι, αϊ with
// diaeresis), the εύει triple-vowel cluster, and punctuation/whitespace
// pass-through in one shot — regressions would be obvious here first.
describe('ELOT 743 sentence conformance', function () {
    it('transliterates whole sentences', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'γιαγιά + χαϊδεύει (αϊ diaeresis, εύει cluster)' => [
            'Η γιαγιά χαϊδεύει τη γάτα.',
            'i giagia chaidevei ti gata.',
        ],
        'γάιδαρος (άι broken diphthong) + κουβαλούσε (double ου)' => [
            'Ο γάιδαρος κουβαλούσε τα ξύλα.',
            'o gaidaros kouvalouse ta xyla.',
        ],
        'νους/του/δουλεύει (ου repetition + εύει) + συνέχεια (υ→y, ει)' => [
            'Ο νους του δουλεύει συνέχεια.',
            'o nous tou doulevei synecheia.',
        ],
        'ευτυχία (ευ voicing before τ) + accents stripped' => [
            'Βρήκα την ευτυχία στα μικρά πράγματα.',
            'vrika tin eftychia sta mikra pragmata.',
        ],
    ]);
});

describe('make() guillemets and edge cases', function () {
    it('strips « » guillemets', function () {
        expect($this->greeklish->make('«γεια»'))->toBe('geia');
    });

    it('passes through latin and numbers untouched', function (string $input, string $expected) {
        expect($this->greeklish->make($input))->toBe($expected);
    })->with([
        'mixed greek + latin' => ['Γεια world', 'geia world'],
        'greek + number' => ['Άρθρο 5', 'arthro 5'],
        'pure latin' => ['hello', 'hello'],
        'exclamation kept' => ['Καλημέρα!', 'kalimera!'],
    ]);

    it('returns an empty string unchanged', function () {
        expect($this->greeklish->make(''))->toBe('');
    });

    it('leaves whitespace-only input unchanged', function () {
        expect($this->greeklish->make('   '))->toBe('   ');
    });
});

describe('malformed UTF-8 robustness', function () {
    // The /u patterns make preg_replace return null on invalid byte sequences;
    // every public method must still honour its ": string" return type instead
    // of throwing a TypeError.
    it('returns a string instead of throwing on invalid UTF-8', function (string $method) {
        expect($this->greeklish->{$method}("\xC3\x28"))->toBeString();
    })->with(['make', 'text', 'slug', 'stopOne', 'stopTwo']);

    it('degrades make()/slug() to an empty string on invalid UTF-8', function () {
        expect($this->greeklish->make("\xC3\x28"))->toBe('')
            ->and($this->greeklish->slug("\xC3\x28"))->toBe('');
    });
});

describe('text()', function () {
    it('transliterates without stripping by default', function () {
        expect($this->greeklish->text('Γεια σου Κόσμε'))->toBe('geia sou kosme');
    });

    it('removes one-letter words when stopOne is true', function () {
        expect($this->greeklish->text('ο σκύλος μου', true))->toBe('skylos mou');
    });

    it('keeps one-letter words when stopOne is false', function () {
        expect($this->greeklish->text('ο σκύλος μου'))->toBe('o skylos mou');
    });

    it('removes two-letter words when stopTwo is true', function () {
        expect($this->greeklish->text('το σπίτι', false, true))->toBe('spiti');
    });

    it('strips one- and two-letter words together', function () {
        expect($this->greeklish->text('ο το σπίτι', true, true))->toBe('spiti');
    });
});

describe('slug()', function () {
    it('builds a url friendly slug', function (string $input, string $expected) {
        expect($this->greeklish->slug($input))->toBe($expected);
    })->with([
        'greeting' => ['Γεια σου Κόσμε', 'geia-sou-kosme'],
        'sentence' => ['Άρθρο για την Ελλάδα', 'arthro-gia-tin-ellada'],
        'punctuation dropped' => ['Καλή χρονιά!', 'kali-chronia'],
        'lowercase phrase' => ['το σπίτι μου', 'to-spiti-mou'],
    ]);

    it('strips one-letter words by default (stopOne defaults to true)', function () {
        expect($this->greeklish->slug('ο σκύλος μου'))->toBe('skylos-mou');
    });

    it('keeps one-letter words when stopOne is false', function () {
        expect($this->greeklish->slug('ο σκύλος μου', false))->toBe('o-skylos-mou');
    });

    it('strips two-letter words when stopTwo is true', function () {
        expect($this->greeklish->slug('το μεγάλο σπίτι', false, true))->toBe('megalo-spiti');
    });

    it('strips html entities', function (string $input) {
        expect($this->greeklish->slug($input))->toBe('geia-kosme');
    })->with([
        'named entity' => ['Γεια &amp; Κόσμε'],
        'nbsp entity' => ['Γεια &nbsp; Κόσμε'],
    ]);

    it('strips one- and two-letter words together', function () {
        expect($this->greeklish->slug('ο το μεγάλο σπίτι', true, true))->toBe('megalo-spiti');
    });

    it('returns an empty string for empty input', function () {
        expect($this->greeklish->slug(''))->toBe('');
    });
});

describe('stopOne() / stopTwo()', function () {
    it('removes standalone one-letter words', function () {
        expect($this->greeklish->stopOne('a bb ccc'))->toBe('bb ccc');
    });

    it('removes standalone two-letter words', function () {
        expect($this->greeklish->stopTwo('a bb ccc'))->toBe('a ccc');
    });
});
