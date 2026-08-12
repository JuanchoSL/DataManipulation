<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Sanitizers\Numbers;

use JuanchoSL\DataManipulation\Manipulators\Strings\StringsManipulators;
use JuanchoSL\DataManipulation\Traits\FilterVarTrait;
use JuanchoSL\DataManipulation\Traits\DelayedManipulationTrait;
use JuanchoSL\DataManipulation\Traits\SanitizerInmutableTrait;

class NumberSanitizers
{

    use FilterVarTrait;
    //use DelayedManipulationTrait, SanitizerInmutableTrait;

    public function getManipulator($value)
    {
        return new StringsManipulators((string) $value);
    }
    /**
     * Apply a sanitization from a given data, retrieving only the integer part. You can use or not the thousand separator
     * @param bool $with_thousand_separator
     * @return NumberSanitizers
     */
    public function integer(bool $with_thousand_separator = false): static
    {
        $options = ($with_thousand_separator) ? FILTER_FLAG_ALLOW_THOUSAND : 0;
        return $this->float($with_thousand_separator)
            ->adaptSeparators($with_thousand_separator, false)
            ->sanitize('filter_var', [FILTER_SANITIZE_NUMBER_INT, $options]);
    }

    /**
     * Apply a sanitization from a given data, retrieving only the integer and decimal part. You can use or not the thousand separator
     * @param bool $with_thousand_separator
     * @return NumberSanitizers
     */
    public function float(bool $with_thousand_separator = false): static
    {
        $options = FILTER_FLAG_ALLOW_FRACTION;
        if ($with_thousand_separator) {
            $options |= FILTER_FLAG_ALLOW_THOUSAND;
        }
        return $this->adaptSeparators($with_thousand_separator, true)->sanitize('filter_var', [FILTER_SANITIZE_NUMBER_FLOAT, $options]);
    }

    protected function adaptSeparators($with_thousand_separator = false, $with_decimals = false)
    {
        return ($with_thousand_separator && $with_decimals) ? $this : $this->sanitize('filter_var', [
            FILTER_CALLBACK,
            [
                'options' => function ($var) use ($with_thousand_separator, $with_decimals) {
                    $breakeable = false;
                    if (($count = substr_count($var, '.')) > 1) {
                        $var = str_replace('.', '', $var);
                    } elseif ($count == 1) {
                        $breakeable = true;
                    }
                    if (($count = substr_count($var, ',')) > 1) {
                        $var = str_replace(',', '', $var);
                    } elseif ($count == 1) {
                        if (!$breakeable/* OR mb_strlen(filter_var(substr($var, strpos($var, ',')), FILTER_SANITIZE_NUMBER_INT)) != 3*/) {
                            $var = str_replace(',', '.', $var);
                        } else {
                            $colon = mb_strpos($var, ',');
                            $dot = mb_strpos($var, '.');
                            $first = min($colon, $dot);
                            $last = max($colon, $dot);
                            $tmp1 = (new StringsManipulators($var))->substring(0, $first);
                            $tmp2 = (new StringsManipulators($var))->substring($first + 1, ($last - 1) - $first);
                            $tmp3 = (new StringsManipulators($var))->substring($last + 1);
                            $char = ($with_thousand_separator) ? ',' : '';
                            $var = (new StringsManipulators((string) $tmp1))->concatenation((string) $tmp2, $char)->concatenation((string) $tmp3, '.');
                        }
                    }
                    $var = (string) $var;
                    if (!$with_decimals && strpos($var, '.') !== false) {
                        $var = mb_substr($var, 0, strrpos($var, '.'));
                    }
                    return $var;
                }
            ]
        ]);
    }
}
