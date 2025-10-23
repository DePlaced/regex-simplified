<?php
use PHPUnit\Framework\TestCase;
use DePlaced\RegexSimplified\Rx;

final class RxTest extends TestCase
{
    public function test_lowercase_only(): void
    {
        $rx = Rx::make()->start()->lowercase()->oneOrMore()->end();
        $this->assertTrue($rx->test('abc'));
        $this->assertFalse($rx->test('Abc'));
    }

    public function test_uppercase_only(): void
    {
        $rx = Rx::make()->start()->uppercase()->oneOrMore()->end();
        $this->assertTrue($rx->test('HELLO'));
        $this->assertFalse($rx->test('Hello'));
    }
}
