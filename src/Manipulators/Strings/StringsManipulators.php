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
        return new StringsManipulators(ucfirst($this->value));
    }

    public function toLowerFirst(): static
    {
        return new StringsManipulators(lcfirst($this->value));
    }

    public function toUpperWords(string $separators = " \t\r\n\f\v"): static
    {
        return new StringsManipulators(ucwords($this->value, $separators));
    }

    public function toUpper(): static
    {
        return new StringsManipulators(strtoupper($this->value));
    }

    public function toLower(): static
    {
        return new StringsManipulators(strtolower($this->value));
    }

    public function padding(int $length, string $pad_string = ' ', int $pad_type = STR_PAD_LEFT): static
    {
        return new StringsManipulators(str_pad($this->value, $length, $pad_string, $pad_type));
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
        return new StringsManipulators(chunk_split($this->value, $length, $separator));
    }

    public function wordWrap(int $length = 76, string $break = "\n", bool $cut_words = false): static
    {
        return new StringsManipulators(wordwrap($this->value, $length, $break, $cut_words));
    }

    public function trim(string $chars = " \n\r\t\v\x00"): static
    {
        return new StringsManipulators(trim($this->value, $chars));
    }

    public function ltrim(string $chars = " \n\r\t\v\x00"): static
    {
        return new StringsManipulators(ltrim($this->value, $chars));
    }

    public function rtrim(string $chars = " \n\r\t\v\x00"): static
    {
        return new StringsManipulators(rtrim($this->value, $chars));
    }

    /*public function crc32(): static
    {
        return new StringsManipulators(crc32($this->value));
    }*/

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

    public function uuEncode(): static
    {
        return new StringsManipulators(convert_uuencode($this->value));
    }

    public function uuDecode(): static
    {
        return new StringsManipulators(convert_uudecode($this->value));
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