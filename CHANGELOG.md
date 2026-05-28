# Changelog

All notable changes to `greeklish` will be documented in this file.

## v1.0.1 - 2026-05-28

### Changed

- Raised the minimum PHP requirement to **8.3**. The v1.0.0 `^8.2` claim was inaccurate: the dev test suite (Pest 4) requires PHP `^8.3`, so the PHP 8.2 CI job in v1.0.0 could never install dependencies. The package code itself uses no 8.3-only syntax — runtime on 8.2 would have worked, but supporting it would require pinning Pest to 3.x. Bumping the constraint reflects the real supported floor.
- Trimmed the CI matrix from `8.2–8.5 × {12,13}` to `8.3–8.5 × {12,13}` (six green jobs instead of seven with one persistently red).

## v1.0.0 - 2026-05-28

First modern release. Revived from the abandoned `skapator/greeklish` (Laravel 4, 2014) and rebuilt for Laravel 12/13 and PHP 8.2+.

### Added

- ELOT 743 / ISO 843 letter-preserving vowel rules: `αι→ai`, `ει→ei`, `οι→oi`, `υι→yi` and single `υ→y`, so Greek names transcribe as on a passport (`Αικατερίνη→aikaterini`, `Ειρήνη→eirini`, `Οικονόμου→oikonomou`, `Υγεία→ygeia`).
- PSR-4 autoloading under the `Kostasch\Greeklish` namespace.
- Laravel package auto-discovery for the service provider and `Greeklish` facade.
- A full Pest test suite covering digraphs, the `αυ`/`ευ`/`ηυ` voicing rules, ELOT 743 name conformance, accent stripping, slugs, and word-stripping flags.
- GitHub Actions CI matrixing PHP 8.2–8.5 against Laravel 12 and 13.

### Changed

- Relicensed from GPL-3.0 to MIT.
- Modernised the source to PHP 8.2 (typed signatures, short array syntax).
- Replaced the Laravel 4 service provider APIs (`$this->package()`, `$this->app->share()`) with a container singleton.

### Fixed

- Uppercase `ΑΥ`/`ΕΥ`/`ΗΥ` now voice correctly before uppercase `Τ` and `Φ`. The original table used Latin `T` (U+0054) and Greek `Ρ` (U+03A1) instead of Greek `Τ` (U+03A4) and `Φ` (U+03A6), so `ΑΥΤΟΣ` produced `avtos` instead of `aftos`.
- Vowels carrying both diaeresis and tonos (`ΐ` U+0390, `ΰ` U+03B0) are now transliterated instead of leaking raw Greek into the output (e.g. `πρωτεΐνη → proteini`).
- The `ηυ` diphthong now handles an accent on the upsilon (`ηύ`/`ΗΎ`), so `ηύξησε → ifxise` instead of `iixise`. The rule previously used `[υΥ]`, omitting `ύ`/`Ύ`.
- `make()`, `text()` and `slug()` no longer throw a `TypeError` on malformed UTF-8 input; they return an empty string instead (relevant when slugging arbitrary user input).
