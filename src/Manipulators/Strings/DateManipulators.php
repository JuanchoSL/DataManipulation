<?php declare(strict_types=1);

namespace JuanchoSL\DataManipulation\Manipulators\Strings;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

class DateManipulators
{
    protected $full_months = [
        "january",
        "february",
        "march",
        "april",
        "may",
        "june",
        "july",
        "august",
        "september",
        "october",
        "november",
        "december",
    ];
    protected $months = [
        "jan",
        "feb",
        "mar",
        "apr",
        "may",
        "jun",
        "jul",
        "aug",
        "sep",
        "oct",
        "nov",
        "dec",
    ];
    protected ?bool $avoid_realtime = null;
    protected bool $use_immutable = false;

    /**
     * When you use a string date without a time, the DateTime response object, use the actual time, if you would set as 00:00:00, can force it with setTimeToZero(true).
     * Using TRUE, it force to set to 0 all time values allways, when a time block is indicated too, in order to prevent delete existing hour, set to null (by default) or 
     * set to FALSE for use providing hour and real time when is not available .
     * @param bool $to_zero
     * @return DateManipulators
     */
    public function setTimeToZero(?bool $to_zero = true): static
    {
        $this->avoid_realtime = (is_bool($to_zero)) ? $to_zero : null;
        return $this;
    }

    /**
     * By default, the response is a DateTime object, in order to use it and modify across your code, if would a DateTimeImmutable, can force the response using setResponseImmutable(true)
     * @param bool $to_immutable
     * @return DateManipulators
     */
    public function setResponseImmutable(bool $to_immutable = true): static
    {
        $this->use_immutable = $to_immutable;
        return $this;
    }

    /**
     * Try to detect the value type and pass to function to convert, if is an integer, the function use as excel when length is < 10, timestamp when integer length is more, or as string in otherwise
     * @param string[] $dates
     * @return mixed
     */
    public function __invoke(string ...$dates): mixed
    {
        foreach ($dates as $key => $date) {
            if (empty($date)) {
                $date = null;
            } elseif (!is_numeric($date)) {
                $date = $this->fromString($date);
            } elseif (strlen($date) < 10) {
                $date = $this->fromExcel((int) $date);
            } else {
                $date = $this->fromTimestamp((int) $date);
            }
            $dates[$key] = $date;
        }
        return (count($dates) == 1) ? current($dates) : $dates;
    }

    /**
     * Convert an excel date formatted integer to DateTime object
     * @param int $input excel date formatted value
     * @return DateTimeInterface|null
     */
    public function fromExcel(int $input): ?DateTimeInterface
    {
        $input = intval($input);
        $input = ($input - 25569) * 86400;
        return $this->fromTimestamp($input);
    }

    /**
     * Convert an integer to DateTime object
     * @param int $input timestamp
     * @return DateTimeInterface|null
     */
    public function fromTimestamp(int $input): ?DateTimeInterface
    {
        return $this->fromString(date("Y-m-d H:i:s", $input));
    }

    /**
     * Try to detect the format date as string and convert to DateTime.
     * It can work with [- / .] separators and try to detect 4 digits as year (1º or 3º position), word or int <=12 as month (1º or 2º position) and 2 digits int > 12 as day (any position)
     * @param string $input Date as string
     * @return DateTimeInterface|null
     */
    public function fromString(string $input): ?DateTimeInterface
    {
        if (strpos($input, '\\') !== false || strpos($input, '+') !== false || strpos($input, ' ') !== false) {
            return $this->finalAdapter(new DateTime($input));
        }
        if (strpos($input, '-') !== false) {
            $input = str_replace('-', '/', $input);
        }
        if (strpos($input, '.') !== false) {
            $input = str_replace('.', '/', $input);
        }
        if (strpos($input, '/') !== false) {
            list($first, $second, $third) = explode('/', $input);

            if (in_array(strtolower($first), $this->months)) {
                $month_format = "M";
            } elseif (in_array(strtolower($first), $this->full_months)) {
                $month_format = "F";
            } elseif (in_array(strtolower($second), $this->months)) {
                $month_format = "M";
            } elseif (in_array(strtolower($second), $this->full_months)) {
                $month_format = "F";
            } elseif (in_array(strtolower($third), $this->months)) {
                $month_format = "M";
            } elseif (in_array(strtolower($third), $this->full_months)) {
                $month_format = "F";
            } else {
                $month_format = "m";
            }

            if (strlen($third) == 4) {
                if ((is_numeric($first) && $first > 12) || !is_numeric($second)) {
                    $format = "d/{$month_format}/Y";
                } elseif ((is_numeric($second) && $second > 12) || !is_numeric($first)) {
                    $format = "{$month_format}/d/Y";
                } else {
                    $format = "d/{$month_format}/Y";
                }
            } elseif (strlen($first) == 4) {
                if ((is_numeric($third) && $third > 12) || !is_numeric($second)) {
                    $format = "Y/{$month_format}/d";
                } elseif ((is_numeric($second) && $second > 12) || !is_numeric($third)) {
                    $format = "Y/d/{$month_format}";
                } else {
                    $format = "Y/{$month_format}/d";
                }
            }
            if (is_null($this->avoid_realtime) or $this->avoid_realtime === true) {
                $format .= '|';
            }
            return $this->fromFormatString($input, $format);
            return $this->fromFormatString($input, '!' . $format);
        }

        if (strpos($input, '/') !== false) {
            list($day, $month, $year) = explode('/', $input);
            $input = "{$year}-{$month}-{$day}";
        }
        //return $this->fromFormatString($input, 'Y-m-d');
        //return new \DateTimeImmutable($input);
    }

    /**
     * This is a most versatile function in order to check a value as Date, selecting desired format to compare. 
     * For 2 digits years, php can convert it as future year if is greater than current year, you can force it to use as a past year
     * @param string $input Date as string formated
     * @param string $format The teorical format to check
     * @param bool $force_past True in order to use 19xx for 2 digits year
     * @return DateTimeInterface|null
     */
    public function fromFormatString(string $input, string $format, bool $force_past = false): ?DateTimeInterface
    {
        $response = null;
        if (!empty($input) && !str_starts_with($input, '00')) {
            $date = DateTime::createFromFormat($format, $input);
            if ($date !== false) {
                if ($force_past && $date->format("Y") >= date("Y")) {
                    return $this->fromFormatString($date->setDate(intval('19' . $date->format('y')), intval($date->format('m')), intval($date->format('d')))->format("Y-m-d"), "Y-m-d");
                }
                $response = $date;//DateTime::createFromFormat("Y-m-d", $date->format("Y-m-d"));
            }
        }
        return $this->finalAdapter($response);
    }

    protected function finalAdapter(?DateTime $result = null): ?DateTimeInterface
    {
        if (!is_null($result)) {
            if ($this->avoid_realtime === true) {
                $result->setTime(0, 0);
            }
            if ($this->use_immutable) {
                $result = DateTimeImmutable::createFromMutable($result);
            }
        }
        return $result;
        //return new DateTimeImmutable($result);
    }
}