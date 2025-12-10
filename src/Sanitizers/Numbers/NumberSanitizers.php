<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Sanitizers\Numbers;

use JuanchoSL\DataManipulation\Traits\FilterVarTrait;

class NumberSanitizers
{

    use FilterVarTrait;

    /**
     * Apply a sanitization from a given data, retrieving only the integer part. You can use or not the thousand separator
     * @param bool $with_thousand_separator
     * @return NumberSanitizers
     */
    public function integer(bool $with_thousand_separator = false): static
    {
        $this->float($with_thousand_separator);
        $options = ($with_thousand_separator) ? FILTER_FLAG_ALLOW_THOUSAND : 0;
        return $this->sanitize(FILTER_SANITIZE_NUMBER_INT, $options);
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
        return $this->sanitize(FILTER_SANITIZE_NUMBER_FLOAT, $options);
    }
}
