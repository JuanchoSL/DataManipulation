<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Manipulators\Strings;

use Stringable;

class StringsManipulators implements Stringable
{

    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function substring(int $offset, ?int $length = null): static
    {
        return new StringsManipulators(mb_substr($this->value, $offset, $length));
        return new StringsManipulators(mb_strcut($this->value, $offset, $length));
        return new StringsManipulators(substr($this->value, $offset, $length));
    }

    public function repeat(int $times): static
    {
        return new StringsManipulators(str_repeat($this->value, $times));
    }

    public function format(string ...$values): static
    {
        return new StringsManipulators(sprintf($this->value, ...$values));
    }

    public function replace(string $search, string $replace, bool $case_sensitive = true): static
    {
        $result = ($case_sensitive) ? str_ireplace($search, $replace, $this->value) : str_replace($search, $replace, $this->value);
        return new StringsManipulators($result);
    }

    public function reverse(): static
    {
        return new StringsManipulators(strrev($this->value));
    }

    public function toUpperFirst(): static
    {
        return new StringsManipulators(mb_ucfirst($this->value));
    }

    public function toLowerFirst(): static
    {
        return new StringsManipulators(mb_lcfirst($this->value));
    }

    public function toUpperWords(string $separators = " \t\r\n\f\v"): static
    {
        return new StringsManipulators(ucwords($this->value, $separators));
    }

    public function toUpper(): static
    {
        return new StringsManipulators(mb_strtoupper($this->value));
    }

    public function toLower(): static
    {
        return new StringsManipulators(mb_strtolower($this->value));
    }

    public function padding(int $length, string $pad_string = ' ', int $pad_type = STR_PAD_LEFT): static
    {
        return new StringsManipulators(mb_str_pad($this->value, $length, $pad_string, $pad_type));
    }

    public function preppend(string $value, string $separator = " "): static
    {
        return new StringsManipulators($value . $separator . $this->value);
    }

    public function concatenation(string $value, string $separator = " "): static
    {
        return new StringsManipulators($this->value . $separator . $value);
    }

    public function chunk(int $length = 76, string $separator = "\r\n"): static
    {
        return new StringsManipulators(implode($separator, mb_str_split($this->value, $length)));
        return new StringsManipulators(chunk_split($this->value, $length, $separator));
    }

    public function wordWrap(int $length = 76, string $break = "\n", bool $cut_words = false): static
    {
        return new StringsManipulators(wordwrap($this->value, $length, $break, $cut_words));
    }

    public function trim(string $chars = " \n\r\t\v\x00"): static
    {
        return new StringsManipulators(mb_trim($this->value, $chars));
    }

    public function ltrim(string $chars = " \n\r\t\v\x00"): static
    {
        return new StringsManipulators(mb_ltrim($this->value, $chars));
    }

    public function rtrim(string $chars = " \n\r\t\v\x00"): static
    {
        return new StringsManipulators(mb_rtrim($this->value, $chars));
    }

    /*public function crc32(): static
    {
        return new StringsManipulators(crc32($this->value));
    }*/

    public function eol(string $to_char = "\r\n"): static
    {
        $string = $this->value;

        if ($to_char != "\r\n") {
            $invert = ($to_char == "\r") ? "\n" : "\r";
            $string = str_replace("\r\n", $invert, $string);
            $string = str_replace($invert, $to_char, $string);
        } else {
            $string = str_replace("\r\n", "\n", $string);
            $string = str_replace("\n", "\r", $string);
            $string = str_replace("\r", $to_char, $string);
        }

        return new StringsManipulators($string);
    }

    public function shuffle(): static
    {
        return new StringsManipulators(str_shuffle($this->value));
    }

    public function rotate13(): static
    {
        return new StringsManipulators(str_rot13($this->value));
    }

    public function md5(): static
    {
        return new StringsManipulators(md5($this->value));
    }

    public function quotedPrintableEncode(): static
    {
        return new StringsManipulators(quoted_printable_encode($this->value));
    }

    public function quotedPrintableDecode(): static
    {
        return new StringsManipulators(quoted_printable_decode($this->value));
    }

    public function convertEncoding(string $to_map = 'UTF-8', ?string $from_map = null): static
    {
        //if (!@mb_check_encoding($this->value, $to_map)) {
            if (empty($from_map)) {
                $encodings = mb_list_encodings();
                $from_map = mb_detect_encoding($this->value, $encodings, true);
                if (empty($from_map)) {
                    $from_map = mb_detect_encoding($this->value, $encodings, false);
                }
            }
            return new StringsManipulators(mb_convert_encoding($this->value, $to_map, $from_map));
        //}
        return $this;
    }

    public function uuEncode(): static
    {
        return new StringsManipulators(convert_uuencode($this->value));
    }

    public function uuDecode(): static
    {
        return new StringsManipulators(convert_uudecode($this->value));
    }

    public function urlEncode(): static
    {
        return new StringsManipulators(rawurlencode($this->value));
    }

    public function urlDecode(): static
    {
        return new StringsManipulators(rawurldecode($this->value));
    }

    public function base64Encode(): static
    {
        return new StringsManipulators(base64_encode($this->value));
    }

    public function base64Decode(): static
    {
        return new StringsManipulators(base64_decode($this->value));
    }

    public function binToHex(): static
    {
        return new StringsManipulators(bin2hex($this->value));
    }

    public function hexToBin(): static
    {
        return new StringsManipulators(hex2bin($this->value));
    }

    public function __tostring(): string
    {
        return (string) $this->value;
    }
}