<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Manipulators\Numbers;

use JuanchoSL\DataManipulation\Manipulators\Strings\StringsManipulators;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Stringable;

class NumbersManipulators implements Stringable, LoggerAwareInterface
{

    use LoggerAwareTrait;

    protected float $value = 0;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * Create an object with the absolute positive value
     * @return NumbersManipulators
     */
    public function absolute(): static
    {
        return new static(abs($this->value));
    }

    /**
     * Create an object with the negated value, if start as positive, convert to negative, and if start as negative then convert to positive
     * @return NumbersManipulators
     */
    public function negation(): static
    {
        return new static(-$this->value);
    }

    /**
     * Create an object with the sum of original value with the new value
     * @param float $value
     * @return NumbersManipulators
     */
    public function sum(float $value): static
    {
        return new static($this->value + $value);
    }

    /**
     * Create an object with the original value substracting the new value
     * @param float $value
     * @return NumbersManipulators
     */
    public function sub(float $value): static
    {
        return new static($this->value - $value);
    }

    /**
     * Create an object with the value as the product of original value and new value
     * @param float $value
     * @return NumbersManipulators
     */
    public function product(float $value): static
    {
        return new static($this->value * $value);
    }

    /**
     * Create an object with the value as the cocient of original value and new value
     * @param float $value
     * @return NumbersManipulators
     */
    public function division(float $value): static
    {
        return new static(fdiv($this->value, $value));
    }

    /**
     * Create an object with the value as the module division of original value and new value
     * @param float $value
     * @return NumbersManipulators
     */
    public function module(float $value): static
    {
        return new static(fmod($this->value, $value));
    }

    /**
     * Create an object with the exponent of the original value 
     * @param float $value
     * @return NumbersManipulators
     */
    public function exponent(float $value): static
    {
        return new static($this->value ** $value);
    }

    /**
     * Create an object with the root of the original value, square root by default
     * @param float $value
     * @return NumbersManipulators
     */
    public function root(int $value = 2): static
    {
        return new static(pow($this->value, 1 / $value));
    }

    /**
     * Create an object with the result of calculate the N percent of the original value
     * @param float $value
     * @return NumbersManipulators
     */
    public function percent(float $value): static
    {
        return $this->product($value)->division(100);
    }

    /**
     * Create an object with the result adding the N percent to the original value
     * @param float $value
     * @return NumbersManipulators
     */
    public function increasePercent(float $value): static
    {
        return $this->percent($value)->sum($this->value);
    }

    /**
     * Create an object with the result decreasing the N percent of the original value
     * @param float $value
     * @return NumbersManipulators
     */
    public function decreasePercent(float $value): static
    {
        return $this->sub(+$this->percent($value)->__tostring());
    }

    /**
     * Create an object with the new value, rounding to desired decimals precision, using 5 (half) as minimum value to round to up, 4 round to DOWN otherwise
     * @param int $decimals_precision
     * @return NumbersManipulators
     */
    public function roundHalfUp(int $decimals_precision): static
    {
        return new static(round($this->value, $decimals_precision, PHP_ROUND_HALF_UP));
    }

    /**
     * Create an object with the new value, rounding to desired decimals precision, using 5 (half) as maximum value to round to down, 6 round to UP otherwise
     * @param int $decimals_precision
     * @return NumbersManipulators
     */
    public function roundHalfDown(int $decimals_precision): static
    {
        return new static(round($this->value, $decimals_precision, PHP_ROUND_HALF_DOWN));
    }

    /**
     * Create an object with the value rounding away to zero, floor for positive, ceil for negative
     * @return NumbersManipulators
     */
    public function roundAwayToZero(int $decimals_precision = 0, bool $half_away_to_zero = true): static
    {
        if (intval($this->value) == $this->value || $decimals_precision == 0) {
            return ($this->value >= 0) ? $this->roundToLowInteger() : $this->roundToHighInteger();
        } elseif ($half_away_to_zero) {
            return ($this->value >= 0) ? $this->roundHalfDown($decimals_precision) : $this->roundHalfUp($decimals_precision);
        } elseif (!$half_away_to_zero) {
            return ($this->value >= 0) ? $this->roundHalfUp($decimals_precision) : $this->roundHalfDown($decimals_precision);
        } else {
            return ($this->value >= 0) ? $this->roundHalfUp($decimals_precision) : $this->roundHalfDown($decimals_precision);
        }
    }

    /**
     * Create an object with the value rounding away from zero, ceil for positive, floor for negative
     * @return NumbersManipulators
     */
    public function roundAwayFromZero(int $decimals_precision = 0, bool $half_away_from_zero = true): static
    {
        if (intval($this->value) == $this->value || $decimals_precision == 0) {
            return ($this->value >= 0) ? $this->roundToHighInteger() : $this->roundToLowInteger();
        } elseif ($half_away_from_zero) {
            return ($this->value >= 0) ? $this->roundHalfUp($decimals_precision) : $this->roundHalfDown($decimals_precision);
        } elseif (!$half_away_from_zero) {
            return ($this->value >= 0) ? $this->roundHalfDown($decimals_precision) : $this->roundHalfUp($decimals_precision);
        } else {
            return ($this->value >= 0) ? $this->roundHalfUp($decimals_precision) : $this->roundHalfDown($decimals_precision);
        }
    }

    /**
     * Create an object with the value rounding to upper integer value (CEIL)
     * @return NumbersManipulators
     */
    public function roundToHighInteger(): static
    {
        return new static(ceil($this->value));
    }

    /**
     * Create an object with the value rounding to next integer value (FLOOR)
     * @return NumbersManipulators
     */
    public function roundToLowInteger(): static
    {
        return new static(floor($this->value));
    }

    /**
     * Create an object with the minimal value between the original and a sequence of new values
     * @param float[] $numbers
     * @return NumbersManipulators
     */
    public function min(float ...$numbers): static
    {
        return new static(min(array_merge([$this->value], func_get_args())));
    }

    /**
     * Create an object with the maximum value between the original and a sequence of new values
     * @param float[] $numbers
     * @return NumbersManipulators
     */
    public function max(float ...$numbers): static
    {
        return new static(max(array_merge([$this->value], func_get_args())));
    }

    /**
     * Create an object with limited range, the maximum and minimal value, using it for supplying if the value is greather or less than
     * @param float $max The maximun value for retrieve
     * @param float $min The minimun value for retrieve, 0 by default
     * @return NumbersManipulators
     */
    public function limitedIntoRange(float $max, float $min = 0): static
    {
        return $this->max($min)->min($max);
    }

    /**
     * Format the number with desired decimals and char separators
     * @param bool $decimal_separator_dot TRUE for use dot (.) as decimal separator
     * @param int $decimals_precision Number of desired decimals
     * @param bool $thousand_separator TRUE for use other than decimal separator, if for decs use dot (.), then use colon (,)
     * @return StringsManipulators The formatted value as StringManipulator object
     */
    public function format(bool $decimal_separator_dot = true, int $decimals_precision = 2, bool $thousand_separator = false): StringsManipulators
    {
        if ($thousand_separator) {
            $thousand_separator = ($decimal_separator_dot) ? ',' : '.';
        } else {
            $thousand_separator = '';
        }
        $decimal_separator_dot = $decimal_separator_dot ? '.' : ',';
        $response = number_format($this->value, $decimals_precision, $decimal_separator_dot, $thousand_separator);
        return new StringsManipulators($response);
    }

    /**
     * Create an object with the natural logarithm of the original value 
     * @param float $base The base to use
     * @return NumbersManipulators
     */
    public function logarithmNatural(float $base): static
    {
        return new static(log($this->value, $base));
    }
    /**
     * Create an object with the natural anti-logarithm
     * @param float $base The base to use
     * @return NumbersManipulators
     */
    public function logarithmInverse(float $base): static
    {
        return (new static($base))->exponent($this->value);
    }

    /**
     * Create an object with the converted number to a new numeric base
     * @param int $from_base The original base of given number
     * @param int $to_base The destiny base to convert
     * @return NumbersManipulators|StringsManipulators
     */
    public function baseConvert(int $from_base, int $to_base): static|StringsManipulators
    {
        $result = base_convert(strval($this->value), $from_base, $to_base);
        if ($to_base > 10) {
            return new StringsManipulators($result);
        } else {
            return new static(floatval($result));
        }
    }

    public function __tostring(): string
    {
        return (string) $this->value;
    }
}