<?php
use PHPUnit\Framework\TestCase;
use RegexGuard\Rx;

final class RxTest extends TestCase
{
    public function test_lowercase_only(): void
    {
        $rx = Rx::make()->start()->lowercase()->oneOrMore()->end();
        $this->assertTrue($rx->test('abc'));
        $this->assertFalse($rx->test('Abc'));
    }

    public function test_alnum_min_max(): void
    {
        $rx = Rx::make()->start()->letter()->number()->repeat(3,6)->end();
        $this->assertFalse($rx->test('a'));    
        $this->assertFalse($rx->test('A-1'));
}
