<?php
namespace DePlaced\RegexSimplified;

final class Rx
{
    private string $pattern = '';
    private string $flags = 'u';

    public static function make(): self { return new self(); }

    public function lowercase(): self { $this->pattern .= '[a-z]'; return $this; }
    public function uppercase(): self { $this->pattern .= '[A-Z]'; return $this; }
    public function letter(): self    { $this->pattern .= '[A-Za-z]'; return $this; }
    public function number(): self    { $this->pattern .= '[0-9]'; return $this; }

    public function oneOrMore(): self { $this->pattern .= '+'; return $this; }
    public function repeat(int $min, ?int $max=null): self {
        $this->pattern .= is_null($max) ? "{${min},}" : "{${min},${max}}";
        return $this;
    }

    public function start(): self { $this->pattern = '^' . $this->pattern; return $this; }
    public function end(): self   { $this->pattern .= '$'; return $this; }

    public function toPreg(): string { return '/' . $this->pattern . '/' . $this->flags; }
    public function test(string $value): bool { return preg_match($this->toPreg(), $value) === 1; }
}
