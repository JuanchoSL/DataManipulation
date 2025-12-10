<?php

namespace JuanchoSL\DataManipulation\Tests\Unit\Manipulators;

use PHPUnit\Framework\TestCase;
use JuanchoSL\DataManipulation\Manipulators\Numbers\NumbersManipulators;

class NumberManipulatorsTest extends TestCase
{
    public function testSum()
    {
        $calc = new NumbersManipulators(2);
        $calc = (string) $calc->sum(3);
        $this->assertEquals(5, +$calc);
    }
    public function testSub()
    {
        $calc = new NumbersManipulators(3);
        $calc = (string) $calc->sub(2);
        $this->assertEquals(1, +$calc);
    }
    public function testProd()
    {
        $calc = new NumbersManipulators(3);
        $calc = (string) $calc->product(2);
        $this->assertEquals(6, +$calc);
    }
    public function testCocient()
    {
        $calc = new NumbersManipulators(3);
        $calc = (string) $calc->division(2);
        $this->assertEquals(1.5, +$calc);
    }
    public function testExponent()
    {
        $calc = new NumbersManipulators(3);
        $calc = (string) $calc->exponent(2);
        $this->assertEquals(9, +$calc);
    }

    public function testRoot()
    {
        $calc = new NumbersManipulators(9);
        $calc = (string) $calc->root(2);
        $this->assertEquals(3, +$calc);

        $calc = new NumbersManipulators(8);
        $calc = (string) $calc->root(3);
        $this->assertEquals(2, +$calc);
    }

    public function testConcatenation()
    {
        $calc = (string) (new NumbersManipulators(400))->product(20)->division(100);
        $this->assertEquals(80, +$calc);

        $calc = (string) (new NumbersManipulators(400))->product(2)->division(100)->root(3);
        $this->assertEquals(2, +$calc);
    }

    public function testPercent()
    {
        $calc = new NumbersManipulators(400);
        $calc = (string) $calc->percent(20);
        $this->assertEquals(80, +$calc);
    }

    public function testIncreasePercent()
    {
        $calc = new NumbersManipulators(400);
        $calc = (string) $calc->increasePercent(20);
        $this->assertEquals(480, +$calc);
    }

    public function testDecreasePercent()
    {
        $calc = new NumbersManipulators(400);
        $calc = (string) $calc->decreasePercent(20);
        $this->assertEquals(320, +$calc);
    }

    public function testRoundUp()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->roundHalfUp(1);
        $this->assertEquals(1.6, +$calc);

        $calc = new NumbersManipulators(1.555);
        $calc = (string) $calc->roundHalfUp(2);
        $this->assertEquals(1.56, +$calc);

        $calc = new NumbersManipulators(1.554);
        $calc = (string) $calc->roundHalfUp(2);
        $this->assertEquals(1.55, +$calc);
    }

    public function testRoundDown()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->roundHalfDown(1);
        $this->assertEquals(1.5, +$calc);

        $calc = new NumbersManipulators(1.555);
        $calc = (string) $calc->roundHalfDown(2);
        $this->assertEquals(1.55, +$calc);

        $calc = new NumbersManipulators(1.555);
        $calc = (string) $calc->roundHalfDown(2);
        $this->assertEquals(1.55, +$calc);
    }

    public function testAbsolute()
    {
        $calc = new NumbersManipulators(-1.55);
        $calc = (string) $calc->absolute();
        $this->assertEquals(1.55, +$calc);
        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->absolute();
        $this->assertEquals(1.55, +$calc);
    }

    public function testNegation()
    {
        $calc = new NumbersManipulators(-1.55);
        $calc = (string) $calc->negation();
        $this->assertEquals(1.55, +$calc);
        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->negation();
        $this->assertEquals(-1.55, +$calc);
    }

    public function testRoundUpInteger()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->roundToHighInteger();
        $this->assertEquals(2, +$calc);
    }

    public function testRoundDownInteger()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->roundToLowInteger();
        $this->assertEquals(1, +$calc);
    }
    public function testGetMin()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->min(2);
        $this->assertEquals(1.55, +$calc);

        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->min(2, 1, 5, 1.56);
        $this->assertEquals(1, +$calc);
    }

    public function testGetMax()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->max(2);
        $this->assertEquals(2, +$calc);

        $calc = new NumbersManipulators(1.55);
        $calc = (string) $calc->max(2, 1, 5, 1.56);
        $this->assertEquals(5, +$calc);
    }

    public function testAwayFromZeroIntegerPositive()
    {
        $calc = new NumbersManipulators(1.55);
        $res = (string) $calc->roundAwayFromZero(0, true);
        $this->assertEquals(2, +$res);
        $res = (string) $calc->roundAwayFromZero(0, false);
        $this->assertEquals(2, +$res);
    }

    public function testAwayFromZeroIntegerNegative()
    {

        $calc = new NumbersManipulators(-1.55);
        $res = (string) $calc->roundAwayFromZero(0, true);
        $this->assertEquals(-2, +$res);
        $res = (string) $calc->roundAwayFromZero(0, false);
        $this->assertEquals(-2, +$res);
    }

    public function testAwayFromZeroFloatPositive()
    {
        $calc = new NumbersManipulators(1.45);
        $res = (string) $calc->roundAwayFromZero(1, true);
        $this->assertEquals(1.5, +$res);
        $res = (string) $calc->roundAwayFromZero(1, false);
        $this->assertEquals(1.4, +$res);
    }

    public function testAwayFromZeroFloatNegative()
    {
        $calc = new NumbersManipulators(-1.55);
        $res = (string) $calc->roundAwayFromZero(1, true);
        $this->assertEquals(-1.5, +$res);
        $res = (string) $calc->roundAwayFromZero(1, false);
        $this->assertEquals(-1.6, +$res);
    }

    public function testAwayToZeroIntegerPositive()
    {
        $calc = new NumbersManipulators(1.55);
        $res = (string) $calc->roundAwayToZero(0, false);
        $this->assertEquals(1, +$res);
        $res = (string) $calc->roundAwayToZero(0, true);
        $this->assertEquals(1, +$res);

    }

    public function testAwayToZeroIntegerNegative()
    {
        $calc = new NumbersManipulators(-1.55);
        $res = (string) $calc->roundAwayToZero(0, true);
        $this->assertEquals(-1, +$res);
        $res = (string) $calc->roundAwayToZero(0, false);
        $this->assertEquals(-1, +$res);
    }

    public function testAwayToZeroFloatPositive()
    {
        $calc = new NumbersManipulators(1.55);
        $res = (string) $calc->roundAwayToZero(1, true);
        $this->assertEquals(1.5, +$res);
        $res = (string) $calc->roundAwayToZero(1, false);
        $this->assertEquals(1.6, +$res);
    }

    public function testAwayToZeroFloatNegative()
    {
        $calc = new NumbersManipulators(-1.55);
        $res = (string) $calc->roundAwayToZero(1, true);
        $this->assertEquals(-1.6, +$res);
        $res = (string) $calc->roundAwayToZero(1, false);
        $this->assertEquals(-1.5, +$res);
    }
}