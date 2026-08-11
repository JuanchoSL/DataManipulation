<?php

namespace JuanchoSL\DataManipulation\Tests\Unit;

use PHPUnit\Framework\TestCase;
use JuanchoSL\DataManipulation\Sanitizers\Numbers\NumberSanitizers;

class NumbersSanitizerTest extends TestCase
{
    public function testIntegerTrue()
    {
        $this->assertEquals(2000, (string) (new NumberSanitizers())->integer()->__invoke('2000€'));
        $this->assertEquals(2000, (string) (new NumberSanitizers())->integer()->__invoke('2000.22'));
        $this->assertEquals(2000, (string) (new NumberSanitizers())->integer()->__invoke('2000.22€'));
        $this->assertEquals(2000, (string) (new NumberSanitizers())->integer()->__invoke('2,000.22€'));
        $this->assertEquals(2000, (string) (new NumberSanitizers())->integer()->__invoke('2000'));
    }

    public function testIntegerCallableTrue()
    {
        $sanitizer = (new NumberSanitizers())->integer();
        $this->assertEquals(2000, (string) $sanitizer('2000'));
        $this->assertEquals(2000, (string) $sanitizer('2000€'));
        $this->assertEquals(2000, (string) $sanitizer('2000.22'));
        $this->assertEquals(2000, (string) $sanitizer('2000.22€'));
        $this->assertEquals(2000, (string) $sanitizer('2,000.22€'));
    }

    /*
    public function testIntegerWithThousandsCallableTrue()
    {
        $sanitizer = (new NumberSanitizers())->integer(true);
        //$this->assertEquals("2,000", $sanitizer('2000'));
        //$this->assertEquals("2,000", $sanitizer('2000€'));
        $this->assertEquals("2,000", $sanitizer('2000.22'));
        $this->assertEquals("2,000", $sanitizer('2000.22€'));
        $this->assertEquals("2,000", $sanitizer('2,000.22€'));
    }
*/
    public function testFloatTrue()
    {
        /*
         */
        $this->assertEquals(2000, (string) (new NumberSanitizers())->float()->__invoke('2000'));
        $this->assertEquals(2000, (string) (new NumberSanitizers())->float()->__invoke('2000€'));
        $this->assertEquals(2000.22, (string) (new NumberSanitizers())->float()->__invoke('2000.22'));
        $this->assertEquals(2000.22, (string) (new NumberSanitizers())->float()->__invoke('2000.22€'));
        $this->assertEquals(2000.22, (string) (new NumberSanitizers())->float()->__invoke('2,000.22€'));
        $this->assertEquals("2.000,22", (string) (new NumberSanitizers())->float(true)->__invoke('2.000,22€'));
        $this->assertEquals("2,000.22", (string) (new NumberSanitizers())->float(true)->__invoke('2,000.22€'));
        $this->assertEquals("2.000.000,22", (string) (new NumberSanitizers())->float(true)->__invoke('2.000.000,22€'));
        $this->assertEquals("2,000,000.22", (string) (new NumberSanitizers())->float(true)->__invoke('2,000,000.22€'));
        $this->assertEquals(2000.22, (string) (new NumberSanitizers())->float()->__invoke('2000,22'));
        $this->assertEquals(2000.22, (string) (new NumberSanitizers())->float()->__invoke('2000,22€'));
        $this->assertEquals(2000000.22, (string) (new NumberSanitizers())->float()->__invoke('2.000.000,22€'));
        $this->assertEquals(2000.22, (string) (new NumberSanitizers())->float()->__invoke('2.000,22€'));
    }

    public function testFloatSanitizerTrue()
    {
        $sanitizer = (new NumberSanitizers())->float();
        $this->assertEquals(2000, (string) $sanitizer('2000'));
        $this->assertEquals(2000, (string) $sanitizer('2000€'));
        $this->assertEquals(2000.22, (string) $sanitizer('2000.22'));
        $this->assertEquals(2000.22, (string) $sanitizer('2000.22€'));
        $this->assertEquals(2000.22, (string) $sanitizer('2000,22'));
        $this->assertEquals(2000.22, (string) $sanitizer('2000,22€'));
        $this->assertEquals(2000.22, (string) $sanitizer('2,000.22€'));
    }
    public function testExtractInteger()
    {
        $sanitizer = (new NumberSanitizers())->float();
        $this->assertEquals(123456789, (string) $sanitizer('123456789N'));
        $this->assertEquals(123456789, (string) $sanitizer('Z123456789N'));
        $this->assertEquals(123456789, (string) $sanitizer('Z123456789'));
    }

}