[![Packagist Version](https://img.shields.io/packagist/v/deplaced/regex-simplified/dev-main?label=version)](https://packagist.org/packages/deplaced/regex-simplified)
[![PHP Version](https://img.shields.io/packagist/php-v/deplaced/regex-simplified?color=blue)](https://packagist.org/packages/deplaced/regex-simplified)
[![License](https://img.shields.io/github/license/DePlaced/regex-simplified.svg?color=orange)](LICENSE)
[![Tests](https://github.com/DePlaced/regex-simplified/actions/workflows/tests.yml/badge.svg)](https://github.com/DePlaced/regex-simplified/actions)

# Regex Simplified
Simple, customizable regex builder focused on letters and numbers. 

Packagist: https://packagist.org/packages/deplaced/regex-simplified

## Install
```bash
composer require DePlaced/regex-simplified
```

## Usage
```bash
use DePlaced\RegexSimplified\Regex;

// Example: match uppercase-only strings
$rx = Regex::make()
    ->start()
    ->uppercase()
    ->oneOrMore()
    ->end();

var_dump($rx->test('HELLO')); // true
var_dump($rx->test('Hello')); // false
```
## API Reference
| Method                      | Description                            |
| --------------------------- | -------------------------------------- |
| `Regex::make()`             | Create a new instance.                 |
| `lowercase()`               | Match lowercase letters `[a-z]`.       |
| `uppercase()`               | Match uppercase letters `[A-Z]`.       |
| `letter()`                  | Match any letter `[A-Za-z]`.           |
| `number()`                  | Match digits `[0-9]`.                  |
| `oneOrMore()`               | Quantifier `+`.                        |
| `repeat($min, $max = null)` | Quantifier `{min,max}`.                |
| `start()`                   | Anchor to start `^`.                   |
| `end()`                     | Anchor to end `$`.                     |
| `toPreg()`                  | Get the final regex string.            |
| `test($string)`             | Test a string against the built regex. |

## Examples
| Pattern              | Chain                                                     | Matches        | Non-matches     |
| -------------------- | --------------------------------------------------------- | -------------- | --------------- |
| `/^[a-z]+$/u`        | `Regex::make()->start()->lowercase()->oneOrMore()->end()` | `abc`, `hello` | `Hello`, `123`  |
| `/^[A-Z]+$/u`        | `Regex::make()->start()->uppercase()->oneOrMore()->end()` | `ABC`, `HELLO` | `Hello`, `abc`  |
| `/^[A-Za-z]{3,5}$/u` | `Regex::make()->start()->letter()->repeat(3,5)->end()`    | `abc`, `Hello` | `he`, `toolong` |
