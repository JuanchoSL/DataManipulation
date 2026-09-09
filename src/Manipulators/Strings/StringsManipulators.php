<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Manipulators\Strings;

use JuanchoSL\DataManipulation\Manipulators\Numbers\NumbersManipulators;
use JuanchoSL\DataManipulation\Sanitizers\Numbers\NumberSanitizers;
use JuanchoSL\Validators\Types\Numbers\NumberValidations;
use JuanchoSL\Validators\Types\Strings\StringValidation;
use JuanchoSL\Validators\Types\Strings\StringValidations;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Stringable;

class StringsManipulators implements Stringable, LoggerAwareInterface
{

    use LoggerAwareTrait;
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function substringBeforeChar(string $char, int $occurrence = 1): static
    {
        $new = new static($this->value);
        $count = mb_substr_count($this->value, $char);
        $validation = (new NumberValidations)->isValueGreatherThan(0)->isValueLessThanOrEquals($count);
        if ($validation(abs($occurrence))) {
            if ($occurrence < 0) {
                $occurrence = $count + ($occurrence + 1);
            }
            $i = 1;
            if ($occurrence > 1) {
                $str = strtok($this->value, $char);
                $new = new static($str);
                do {
                    if (($str = strtok($char)) !== false) {
                        $new = $new->concatenation($str, $char);
                    }
                } while (++$i < $occurrence && !empty($str));
            } else {
                $length = mb_stripos($this->value, $char) or null;
                $new = $new->substring(0, $length);
            }
        } elseif ($occurrence < 0) {
            $new = $new->replace($this->value, '', true);
        }
        return $new;
    }

    public function substringAfterChar(string $char, int $occurrence = 1): static
    {
        $new = new static($this->value);
        $count = mb_substr_count($this->value, $char);
        $validation = (new NumberValidations)->isValueGreatherThan(0)->isValueLessThanOrEquals($count);
        if ($validation(abs($occurrence))) {
            if ($occurrence < 0) {
                $occurrence = $count - abs($occurrence + 1);
            }
            $i = 1;
            if ($occurrence > 1) {
                $str = strtok($this->value, $char);
                $new = $new->substring(mb_strlen($str . $char));
                do {
                    if (($_str = strtok($char)) !== false) {
                        $new = $new->substring(mb_strlen($_str . $char));
                        //$str .= $char . $_str;
                    }
                } while (++$i < $occurrence && !empty($_str));
                //$new = $new->replace($str . $char, '', true);
            } else {
                $new = $new->substring(intval(mb_stripos($this->value, $char)) + mb_strlen($char));
            }
        } elseif ($occurrence > 0) {
            $new = $new->replace($this->value, '', true);
        }
        return $new;
    }

    public function substring(int $offset, ?int $length = null): static
    {
        $result = (function_exists('mb_substr')) ? mb_substr($this->value, $offset, $length) : substr($this->value, $offset, $length);
        return new static($result);
    }

    public function repeat(int $times): static
    {
        return new static(str_repeat($this->value, $times));
    }

    public function format(string ...$values): static
    {
        return new static(sprintf($this->value, ...$values));
    }

    public function replace(string $search, string $replace, bool $case_sensitive = true): static
    {
        $result = ($case_sensitive) ? str_replace($search, $replace, $this->value) : str_ireplace($search, $replace, $this->value);
        return new static($result);
    }

    public function reverse(): static
    {
        $value = new static('');
        if (mb_strlen($this->value) < strlen($this->value)) {
            $elements = array_reverse($this->split(1));
            foreach ($elements as $element) {
                $value = $value->concatenation((string) $element, '');
            }
        } else {
            $value = $value->concatenation(strrev($this->value), '');
        }
        return $value;
    }

    public function toUpperFirst(): static
    {
        $result = (function_exists('mb_ucfirst')) ? mb_ucfirst($this->value) : ucfirst($this->value);
        return new static($result);
    }

    public function toLowerFirst(): static
    {
        $result = (function_exists('mb_lcfirst')) ? mb_lcfirst($this->value) : lcfirst($this->value);
        return new static($result);
    }

    public function toUpperWords(string $separators = " \t\r\n\f\v"): static
    {
        $result = $this->value;
        if (mb_strlen($this->value) < strlen($this->value) OR !function_exists('ucwords')) {
            foreach (mb_str_split($separators) as $separator) {
                $new = new static("");
                $iterable = (new static($result))->explode($separator);
                foreach ($iterable as $char) {
                    $new = $new->concatenation((string) $char->toUpperFirst(), $separator);
                }
                $result = (string) $new->ltrim($separator);
            }
        } else {
            $result = ucwords($this->value, $separators);
        }
        return new static($result);
    }

    public function toUpper(): static
    {
        $result = (function_exists('mb_strtoupper')) ? mb_strtoupper($this->value) : strtoupper($this->value);
        return new static($result);
    }

    public function toLower(): static
    {
        $result = (function_exists('mb_strtolower')) ? mb_strtolower($this->value) : strtolower($this->value);
        return new static($result);
    }

    public function padding(int $length, string $pad_string = ' ', int $pad_type = STR_PAD_LEFT): static
    {
        if (function_exists('mb_str_pad')) {
            $result = mb_str_pad($this->value, $length, $pad_string, $pad_type);
        } else {
            $val = (new StringValidations())->isMultibyte();
            if ($val->getResult($this->value) OR $val->getResult($pad_string)) {
                $length = (new NumbersManipulators($length))
                    ->sub(mb_strlen($this->value))
                    ->product(strlen($pad_string))
                    ->division(mb_strlen($pad_string))
                    ->roundToLowInteger()
                    ->sum(strlen($this->value))
                    ->__tostring();
            }
            $result = str_pad($this->value, +$length, $pad_string, $pad_type);
        }
        return new static($result);
    }

    public function preppend(string $value, string $separator = " "): static
    {
        return new static($value . $separator . $this->value);
    }

    public function concatenation(string $value, string $separator = " "): static
    {
        return new static($this->value . $separator . $value);
    }

    public function chunk(int $length = 76, string $separator = "\r\n"): static
    {
        $value = new static('');
        $elements = $this->split($length);
        foreach ($elements as $element) {
            $value = $value->concatenation((string) $element, $separator);
        }
        return $value->trim($separator);
    }

    public function wordWrap(int $length = 76, string $break = "\n", bool $cut_words = false): static
    {
        if (mb_strlen($this->value) < strlen($this->value) OR !function_exists('wordwrap')) {
            foreach ($this->explode(' ') as $chars) {
                $chars = $chars->trim();
                if (StringValidation::isLengthGreatherOrEqualsThan((string) $chars, $length)) {
                    if ($cut_words) {
                        $chars = $chars->chunk($length, $break);
                    }
                    $chars = $chars->concatenation('', $break);
                    $str = '';
                }
                if (!isset($new)) {
                    $new = $chars;
                    continue;
                } elseif (!isset($str)) {
                    $str = (string) $new;
                }
                $chars = (string) $chars;
                if (mb_strlen($str . ' ' . $chars) < $length) {
                    $separator = ' ';
                    $str .= ' ' . $chars;
                } else {
                    $separator = $break;
                    $str = $chars;
                }
                $new = $new->trim()->concatenation($chars, $separator);
            }
            return $new->trim($break);
        }
        return new static(wordwrap($this->value, $length, $break, $cut_words));
    }

    public function trim(string $chars = " \n\r\t\v\x00"): static
    {
        $result = (function_exists('mb_trim')) ? mb_trim($this->value, $chars) : trim($this->value, $chars);
        return new static($result);
    }

    public function ltrim(string $chars = " \n\r\t\v\x00"): static
    {
        $result = (function_exists('mb_ltrim')) ? mb_ltrim($this->value, $chars) : ltrim($this->value, $chars);
        return new static($result);
    }

    public function rtrim(string $chars = " \n\r\t\v\x00"): static
    {
        $result = (function_exists('mb_rtrim')) ? mb_rtrim($this->value, $chars) : rtrim($this->value, $chars);
        return new static($result);
    }

    /*public function crc32(): static
    {
        return new static(crc32($this->value));
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
        return new static($string);
    }

    public function shuffle(): static
    {
        return new static(str_shuffle($this->value));
    }

    public function rotate13(): static
    {
        return new static(str_rot13($this->value));
    }

    public function md5(): static
    {
        return new static(md5($this->value));
    }

    public function quotedPrintableEncode(): static
    {
        return new static(quoted_printable_encode($this->value));
    }

    public function quotedPrintableDecode(): static
    {
        return new static(quoted_printable_decode($this->value));
    }

    public function convertEncoding(string $to_map = 'UTF-8', ?string $from_map = null): static
    {
        if (empty($from_map)) {
            $encodings = mb_list_encodings();
            $from_map = mb_detect_encoding($this->value, $encodings, true);
            if (empty($from_map)) {
                $from_map = mb_detect_encoding($this->value, $encodings, false);
            }
        }
        $result = mb_convert_encoding($this->value, $to_map, $from_map);
        return new static($result);
    }

    public function uuEncode(): static
    {
        return new static(convert_uuencode($this->value));
    }

    public function uuDecode(): static
    {
        return new static(convert_uudecode($this->value));
    }

    public function urlEncode(): static
    {
        return new static(rawurlencode($this->value));
    }

    public function urlDecode(): static
    {
        return new static(rawurldecode($this->value));
    }

    public function base64Encode(): static
    {
        return new static(base64_encode($this->value));
    }

    public function base64Decode(): static
    {
        return new static(base64_decode($this->value));
    }

    public function base64UrlEncode(): static
    {
        return (new static($this->value))->base64Encode()->replace('+', '-')->replace('/', '_')->rtrim('=');
    }

    public function base64UrlDecode(): static
    {
        return (new static($this->value))->replace('-', '+')->replace('_', '/')->base64Decode();
    }

    public function binToHex(): static
    {
        return new static(bin2hex($this->value));
    }

    public function hexToBin(): static
    {
        return new static(hex2bin($this->value));
    }

    public function hash(string $algorithm, bool $binary = false): static
    {
        return new static(hash($algorithm, $this->value, $binary));
    }

    public function hashHmac(string $algorithm, string $key, bool $binary = false): static
    {
        return new static(hash_hmac($algorithm, $this->value, $key, $binary));
    }

    public function explode(string $separator, int $limit = PHP_INT_MAX): iterable
    {
        return array_map(function ($partial) {
            return new static($partial);
        }, explode($separator, $this->value, $limit));
    }

    public function split(int $length = 1): iterable
    {
        $data = (mb_strlen($this->value) < strlen($this->value)) ? mb_str_split($this->value, $length) : str_split($this->value, $length);
        return array_map(function ($partial) {
            return new static($partial);
        }, $data);
    }

    public function filter_var(int $filter, mixed $options)
    {
        $result = filter_var($this->value, $filter, $options);
        return new static($result);
    }

    public function toNumber(): NumbersManipulators
    {
        $sanitizator = new NumberSanitizers();
        $sanitizator = $sanitizator->float(false);
        return (new NumbersManipulators(floatval((string) $sanitizator($this->value))));
    }
    public function __tostring(): string
    {
        return (string) $this->value;
    }
}