<?php

namespace JuanchoSL\DataManipulation\Tests\Unit\Manipulators;

use JuanchoSL\DataManipulation\Manipulators\Numbers\FunctionsNumbersManipulators;
use PHPUnit\Framework\TestCase;
use JuanchoSL\DataManipulation\Manipulators\Numbers\NumbersManipulators;

class NumberManipulatorTest extends TestCase
{
    public function testSum()
    {
        $val = FunctionsNumbersManipulators::sum(2, 3);
        $this->assertEquals(5, +$val);

        $val = FunctionsNumbersManipulators::sum(2, 4.5);
        $this->assertEquals(6.5, +$val);
    }
    public function testSub()
    {
        $val = FunctionsNumbersManipulators::sub(3, 2);
        $this->assertEquals(1, +$val);

        $val = FunctionsNumbersManipulators::sub(3, 1.5);
        $this->assertEquals(1.5, +$val);
    }
    public function testProd()
    {
        $val = FunctionsNumbersManipulators::product(3, 2);
        $this->assertEquals(6, +$val);

        $val = FunctionsNumbersManipulators::product(3, 2.5);
        $this->assertEquals(7.5, +$val);
    }
    public function testCocient()
    {
        $val = FunctionsNumbersManipulators::division(3, 2);
        $this->assertEquals(1.5, +$val);

        $val = FunctionsNumbersManipulators::division(3, 3);
        $this->assertEquals(1, +$val);
    }
    public function testExponent()
    {
        $val = FunctionsNumbersManipulators::exponent(3, 2);
        $this->assertEquals(9, +$val);

        $val = FunctionsNumbersManipulators::exponent(3, 3);
        $this->assertEquals(27, +$val);
    }

    public function testRoot()
    {
        $calc = FunctionsNumbersManipulators::root(9, 2);
        $this->assertEquals(3, +$calc);

        $calc = new NumbersManipulators(8);
        $calc = FunctionsNumbersManipulators::root(8, 3);
        $this->assertEquals(2, +$calc);
    }

    public function testPercent()
    {
        $val = FunctionsNumbersManipulators::percent(400, 20);
        $this->assertEquals(80, +$val);

        $val = FunctionsNumbersManipulators::percent(400, 200);
        $this->assertEquals(800, +$val);
    }

    public function testIncreasePercent()
    {
        $val = FunctionsNumbersManipulators::increasePercent(400,20);
        $this->assertEquals(480, +$val);

        $val = FunctionsNumbersManipulators::increasePercent(400,200);
        $this->assertEquals(1200, +$val);
    }

    public function testDecreasePercent()
    {
        $val = FunctionsNumbersManipulators::decreasePercent(400,20);
        $this->assertEquals(320, +$val);

        $val = FunctionsNumbersManipulators::decreasePercent(400,50);
        $this->assertEquals(200, +$val);
    }

    public function testRoundUp()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = FunctionsNumbersManipulators::roundHalfUp(1.55,1);
        $this->assertEquals(1.6, +$calc);

        $calc = new NumbersManipulators(1.555);
        $calc = FunctionsNumbersManipulators::roundHalfUp(1.555,2);
        $this->assertEquals(1.56, +$calc);

        $calc = new NumbersManipulators(1.554);
        $calc = FunctionsNumbersManipulators::roundHalfUp(1.554,2);
        $this->assertEquals(1.55, +$calc);
    }

    public function testRoundDown()
    {
        $calc = FunctionsNumbersManipulators::roundHalfDown(1.55,1);
        $this->assertEquals(1.5, +$calc);

        $calc = FunctionsNumbersManipulators::roundHalfDown(1.555,2);
        $this->assertEquals(1.55, +$calc);

        $calc = FunctionsNumbersManipulators::roundHalfDown(1.555,2);
        $this->assertEquals(1.55, +$calc);
    }

    public function testAbsolute()
    {
        $calc = FunctionsNumbersManipulators::absolute(-1.55);
        $this->assertEquals(1.55, +$calc);

        $calc = FunctionsNumbersManipulators::absolute(1.55);
        $this->assertEquals(1.55, +$calc);
    }

    public function testNegation()
    {
        $calc = FunctionsNumbersManipulators::negation(-1.55);
        $this->assertEquals(1.55, +$calc);
        $calc = FunctionsNumbersManipulators::negation(1.55);
        $this->assertEquals(-1.55, +$calc);
    }

    public function testRoundUpInteger()
    {
        $calc = new NumbersManipulators(1.55);
        $val = FunctionsNumbersManipulators::roundToHighInteger(1.55);
        $this->assertEquals(2, +$val);

        $calc = new NumbersManipulators(1.00001);
        $val = FunctionsNumbersManipulators::roundToHighInteger(1.00001);
        $this->assertEquals(2, +$val);
    }

    public function testRoundDownInteger()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = FunctionsNumbersManipulators::roundToLowInteger(1.55);
        $this->assertEquals(1, +$calc);

        $calc = new NumbersManipulators(1.99);
        $calc = FunctionsNumbersManipulators::roundToLowInteger(1.99);
        $this->assertEquals(1, +$calc);
    }
    public function testGetMin()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = FunctionsNumbersManipulators::min(1.55,2);
        $this->assertEquals(1.55, +$calc);

        $calc = new NumbersManipulators(1.55);
        $calc = FunctionsNumbersManipulators::min(1.55,2, 1, 5, 1.56);
        $this->assertEquals(1, +$calc);
    }

    public function testGetMax()
    {
        $calc = new NumbersManipulators(1.55);
        $calc = FunctionsNumbersManipulators::max(1.55,2);
        $this->assertEquals(2, +$calc);

        $calc = new NumbersManipulators(1.55);
        $calc = FunctionsNumbersManipulators::max(1.55,2, 1, 5, 1.56);
        $this->assertEquals(5, +$calc);
    }

    public function testAwayFromZeroIntegerPositive()
    {
        $calc = new NumbersManipulators(1.55);
        $res = FunctionsNumbersManipulators::roundAwayFromZero(1.55,0, true);
        $this->assertEquals(2, +$res);
        $res = FunctionsNumbersManipulators::roundAwayFromZero(1.55,0, false);
        $this->assertEquals(2, +$res);
    }

    public function testAwayFromZeroIntegerNegative()
    {

        $calc = new NumbersManipulators(-1.55);
        $res = FunctionsNumbersManipulators::roundAwayFromZero(-1.55,0, true);
        $this->assertEquals(-2, +$res);
        $res = FunctionsNumbersManipulators::roundAwayFromZero(-1.55,0, false);
        $this->assertEquals(-2, +$res);
    }

    public function testAwayFromZeroFloatPositive()
    {
        $calc = new NumbersManipulators(1.45);
        $res = FunctionsNumbersManipulators::roundAwayFromZero(1.45,1, true);
        $this->assertEquals(1.5, +$res);
        $res = FunctionsNumbersManipulators::roundAwayFromZero(1.45,1, false);
        $this->assertEquals(1.4, +$res);
    }

    public function testAwayFromZeroFloatNegative()
    {
        $calc = new NumbersManipulators(-1.55);
        $res = FunctionsNumbersManipulators::roundAwayFromZero(-1.55,1, true);
        $this->assertEquals(-1.5, +$res);
        $res = FunctionsNumbersManipulators::roundAwayFromZero(-1.55,1, false);
        $this->assertEquals(-1.6, +$res);
    }

    public function testAwayToZeroIntegerPositive()
    {
        $calc = new NumbersManipulators(1.55);
        $res = FunctionsNumbersManipulators::roundAwayToZero(1.55,0, false);
        $this->assertEquals(1, +$res);
        $res = FunctionsNumbersManipulators::roundAwayToZero(1.55,0, true);
        $this->assertEquals(1, +$res);

    }

    public function testAwayToZeroIntegerNegative()
    {
        $calc = new NumbersManipulators(-1.55);
        $res = FunctionsNumbersManipulators::roundAwayToZero(-1.55,0, true);
        $this->assertEquals(-1, +$res);
        $res = FunctionsNumbersManipulators::roundAwayToZero(-1.55,0, false);
        $this->assertEquals(-1, +$res);
    }

    public function testAwayToZeroFloatPositive()
    {
        $calc = new NumbersManipulators(1.55);
        $res = FunctionsNumbersManipulators::roundAwayToZero(1.55,1, true);
        $this->assertEquals(1.5, +$res);
        $res = FunctionsNumbersManipulators::roundAwayToZero(1.55,1, false);
        $this->assertEquals(1.6, +$res);
    }

    public function testAwayToZeroFloatNegative()
    {
        $calc = new NumbersManipulators(-1.55);
        $res = FunctionsNumbersManipulators::roundAwayToZero(-1.55,1, true);
        $this->assertEquals(-1.6, +$res);
        $res = FunctionsNumbersManipulators::roundAwayToZero(-1.55,1, false);
        $this->assertEquals(-1.5, +$res);
    }
    public function testFormattingNumber()
    {
        /*
        $this->markTestSkipped();
        $values = [
            ['2,000.00', '2000', '2000.00', '2000,00'],
            ['2000.00', '2000', '2000.00', '2000,00'],
            ['2000.01', '2000', '2000.01', '2000,01'],
            ['2000,00', '2000', '2000.00', '2000,00'],
            ['2.000,00', '2000', '2000.00', '2000,00'],
            ['2,000.00€', '2000', '2000.00', '2000,00'],
            ['2000.00€', '2000', '2000.00', '2000,00'],
            ['2000.01€', '2000', '2000.01', '2000,01'],
            ['2000,00€', '2000', '2000.00', '2000,00'],
            ['2.000,00€', '2000', '2000.00', '2000,00'],
            ['2.000.000,00','2000000','2000000.00','2000000,00'],
            ['2.000.000,00€','2000000','2000000.00','2000000,00'],
            ['2,000,000.00','2000000','2000000.00','2000000,00'],
            ['2,000,000.00€','2000000','2000000.00','2000000,00'],
        ];
        foreach ($values as $value) {
            list($org, $mod_cero, $mod_dot, $mod_comma) = $value;
            $manipulator = new NumbersManipulators($org);
            $this->assertEquals($mod_cero, (string) $manipulator->format(true, 0), "Value: {$org}");
            $this->assertEquals($mod_dot, (string) $manipulator->format(true, 2), "Value: {$org}");
            $this->assertEquals($mod_comma, (string) $manipulator->format(false, 2), "Value: {$org}");
        }
    */

        $values = [
            ['2000,00', '2,000', '2,000.00', '2.000,00'],
            [2000.00, '2,000', '2,000.00', '2.000,00'],
            [2000.00, '2,000', '2,000.00', '2.000,00'],
            [2000.01, '2,000', '2,000.01', '2.000,01'],
            /*
            ['2.000,00', '2,000', '2,000.00', '2.000,00'],
            [2,000.00, '2,000', '2,000.00', '2.000,00'],
            [2000.00, '2,000', '2,000.00', '2.000,00'],
            [2000.01, '2,000', '2,000.01', '2.000,01'],
            [2000,00, '2,000', '2,000.00', '2.000,00'],
            [2.000,00, '2,000', '2,000.00', '2.000,00'],
            //[2.000.000,00,'2,000,000','2,000,000.00','2.000.000,00'],
            //[2.000.000,00,'2,000,000','2,000,000.00','2.000.000,00'],
            [2,000,000.00,'2,000,000','2,000,000.00','2.000.000,00'],
            [2,000,000.00,'2,000,000','2,000,000.00','2.000.000,00']
            */
        ];
        foreach ($values as $value) {
            list($org, $mod_cero, $mod_dot, $mod_comma) = $value;
            $manipulator = new NumbersManipulators(floatval($org));
            //echo print_r($manipulator->toNumber()->format(true, 2), true);exit;
            //echo print_r($manipulator->format(true,0,true)->__tostring(), true);exit;
            $this->assertEquals($mod_cero, (string) $manipulator->format(true, 0, true), "Value: {$org}");
            $this->assertEquals($mod_dot, (string) $manipulator->format(true, 2, true), "Value: {$org}");
            $this->assertEquals($mod_comma, (string) $manipulator->format(false, 2, true), "Value: {$org}");
        }
    }
}