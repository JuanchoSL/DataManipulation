<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Sanitizers\Strings;

use JuanchoSL\DataManipulation\Traits\FilterVarTrait;

class StringSanitizers
{

    use FilterVarTrait;
    
    /**
     * Extract and sanitize only the part of a given string that validate as email
     * @return StringSanitizers
     */
    public function email(): static
    {
        return $this->sanitize(FILTER_SANITIZE_EMAIL, FILTER_FLAG_EMPTY_STRING_NULL);
    }

    /**
     * Extract and sanitize only the the part of a given string that validate as an url
     * @return StringSanitizers
     */
    public function url(): static
    {
        return $this->sanitize(FILTER_SANITIZE_URL, FILTER_FLAG_EMPTY_STRING_NULL);
    }

    /**
     * Sanitize a given string adding slashes
     * @return StringSanitizers
     */
    public function addSlashes(): static
    {
        return $this->sanitize(FILTER_SANITIZE_ADD_SLASHES, FILTER_FLAG_EMPTY_STRING_NULL);
    }

    /**
     * Sanitize all special chars from a given string, and can or not encode quotes
     * @param bool $encode_quotes
     * @return StringSanitizers
     */
    public function htmlSpecialChars(bool $encode_quotes = true): static
    {
        $options = ($encode_quotes) ? 0 : FILTER_FLAG_NO_ENCODE_QUOTES;
        return $this->sanitize(FILTER_SANITIZE_FULL_SPECIAL_CHARS, $options | FILTER_FLAG_ENCODE_AMP);
    }

    /**
     * Sanitize a given string, stripping html tags
     * @return StringSanitizers
     */
    public function stripTags(): static
    {
        return $this->sanitize(FILTER_UNSAFE_RAW, [
            'callback' => function ($var) {
                return strip_tags($var);
            }
        ]);
        return $this->sanitize(FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }
}
