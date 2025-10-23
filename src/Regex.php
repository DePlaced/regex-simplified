<?php
namespace DePlaced\RegexSimplified;

/**
 * Class Regex
 *
 * A minimal, fluent regex builder for PHP.
 * Provides chainable methods to construct regular expressions
 * for letters and numbers in a readable way.
 *
 * Example:
 * ```php
 * $rx = Regex::make()->start()->uppercase()->oneOrMore()->end();
 * $rx->test('HELLO'); // true
 * ```
 */
final class Regex
{
    /**
     * The regex pattern being built (without delimiters).
     */
    private string $pattern = '';

    /**
     * PCRE flags (default: 'u' for UTF-8 mode).
     */
    private string $flags = 'u';

    /**
     * Create a new Regex instance.
     *
     * @return self
     */
    public static function make(): self
    {
        return new self();
    }

    // -------------------------------------------------------------------------
    // Character groups
    // -------------------------------------------------------------------------

    /**
     * Match any lowercase ASCII letter (a–z).
     *
     * @example
     *  Regex::make()->lowercase()->oneOrMore();
     *
     * @return self
     */
    public function lowercase(): self
    {
        $this->pattern .= '[a-z]';
        return $this;
    }

    /**
     * Match any uppercase ASCII letter (A–Z).
     *
     * @example
     *  Regex::make()->uppercase()->oneOrMore();
     *
     * @return self
     */
    public function uppercase(): self
    {
        $this->pattern .= '[A-Z]';
        return $this;
    }

    /**
     * Match any letter (upper or lowercase).
     *
     * @example
     *  Regex::make()->letter()->oneOrMore();
     *
     * @return self
     */
    public function letter(): self
    {
        $this->pattern .= '[A-Za-z]';
        return $this;
    }

    /**
     * Match any numeric digit (0–9).
     *
     * @example
     *  Regex::make()->number()->oneOrMore();
     *
     * @return self
     */
    public function number(): self
    {
        $this->pattern .= '[0-9]';
        return $this;
    }

    // -------------------------------------------------------------------------
    // Quantifiers
    // -------------------------------------------------------------------------

    /**
     * Match one or more occurrences of the previous token (`+` quantifier).
     *
     * @example
     *  Regex::make()->letter()->oneOrMore();
     *
     * @return self
     */
    public function oneOrMore(): self
    {
        $this->pattern .= '+';
        return $this;
    }

    /**
     * Match a range of repetitions of the previous token (`{min,max}` quantifier).
     *
     * @param int      $min Minimum number of occurrences.
     * @param int|null $max Maximum number of occurrences (null = unbounded).
     *
     * @example
     *  Regex::make()->number()->repeat(3, 5); // {3,5}
     *  Regex::make()->letter()->repeat(2);    // {2,}
     *
     * @return self
     */
    public function repeat(int $min, ?int $max = null): self
    {
        if (is_null($max)) {
            $this->pattern .= '{' . $min . ',}';
        } else {
            $this->pattern .= '{' . $min . ',' . $max . '}';
        }
        return $this;
    }

    // -------------------------------------------------------------------------
    // Anchors
    // -------------------------------------------------------------------------

    /**
     * Anchor the pattern to the start of the string (`^`).
     *
     * @example
     *  Regex::make()->start()->lowercase()->oneOrMore();
     *
     * @return self
     */
    public function start(): self
    {
        $this->pattern = '^' . $this->pattern;
        return $this;
    }

    /**
     * Anchor the pattern to the end of the string (`$`).
     *
     * @example
     *  Regex::make()->lowercase()->oneOrMore()->end();
     *
     * @return self
     */
    public function end(): self
    {
        $this->pattern .= '$';
        return $this;
    }

    // -------------------------------------------------------------------------
    // Build and test
    // -------------------------------------------------------------------------

    /**
     * Convert the internal pattern to a valid PCRE string with delimiters and flags.
     *
     * @example
     *  $rx = Regex::make()->letter()->oneOrMore();
     *  echo $rx->toPreg(); // '/[A-Za-z]+/u'
     *
     * @return string
     */
    public function toPreg(): string
    {
        return '/' . $this->pattern . '/' . $this->flags;
    }

    /**
     * Test a string value against the built regex pattern.
     *
     * @param string $value The input string to test.
     *
     * @example
     *  $rx = Regex::make()->lowercase()->oneOrMore();
     *  $rx->test('abc'); // true
     *  $rx->test('ABC'); // false
     *
     * @return bool True if the value matches the pattern; otherwise false.
     */
    public function test(string $value): bool
    {
        return preg_match($this->toPreg(), $value) === 1;
    }
}
