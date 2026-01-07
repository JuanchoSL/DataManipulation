<?php

namespace JuanchoSL\DataManipulation\Tests\Unit\Sanitizers;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use JuanchoSL\DataManipulation\Manipulators\Strings\DateManipulators;

class DateManipulatorsTest extends TestCase
{

    public function setUp(): void
    {
        ini_set("date.timezone", "Europe/Madrid");
    }

    public function testDateStarthourAsString()
    {
        $timestamp = strtotime('2025-11-30');
        $sanitizer = (new DateManipulators())->setTimeToZero(true);
        $this->assertEquals($timestamp, $sanitizer("2025-11-30")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("2025/11/30")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("2025.11.30")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("30-11-2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("30/11/2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("30.11.2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("11-30-2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("11/30/2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("11.30.2025")->getTimestamp());
    }

    public function testDateStarthourAsTimestamp()
    {
        $timestamp = strtotime('2025-11-30');
        $sanitizer = (new DateManipulators())->setTimeToZero(true);
        $this->assertEquals($timestamp, $sanitizer(1764460800)->getTimestamp());
    }

    public function testDateTimeAsTimestamp()
    {
        $timestamp = strtotime('2025-11-30 15:00:00');
        $sanitizer = (new DateManipulators(new DateTimeZone("Europe/Madrid")))->setTimeToZero(false);
        $this->assertEquals($timestamp, $sanitizer(1764511200)->getTimestamp());
    }

    public function testDateStartHourAsTimestampWithHour()
    {
        $timestamp1 = strtotime('2025-11-30 00:00:00');
        $timestamp2 = strtotime('2025-11-30 15:00:00');
        $sanitizer = (new DateManipulators())->setTimeToZero(true);
        $this->assertEquals($timestamp1, $sanitizer($timestamp2)->getTimestamp());
    }
    public function testDateTimeAsTimestampWithHour()
    {
        $timestamp1 = strtotime('2025-11-30 15:00:00');
        $timestamp2 = strtotime('2025-11-30 15:00:00');
        $sanitizer = (new DateManipulators())->setTimeToZero(false);
        $this->assertEquals($timestamp1, $sanitizer($timestamp2)->getTimestamp());
        $sanitizer = (new DateManipulators())->setTimeToZero(null);
        $this->assertEquals($timestamp1, $sanitizer($timestamp2)->getTimestamp());
    }

    public function testDateStarthourAsExcelValue()
    {
        $timestamp = strtotime('2025-11-30');
        $sanitizer = (new DateManipulators())->setTimeToZero(true);
        $this->assertEquals($timestamp, $sanitizer(45991)->getTimestamp());
    }

    public function testDateRealtimeASFormat()
    {
        $timestamp = strtotime(date('2025-11-30 H:i:s'));
        $sanitizer = (new DateManipulators())->setTimeToZero(false);
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("2025-11-30", "Y-m-d")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("2025/11/30", "Y/m/d")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("2025.11.30", "Y.m.d")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("30-11-2025", "d-m-Y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("30/11/2025", "d/m/Y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("30.11.2025", "d.m.Y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("11-30-2025", "m-d-Y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("11/30/2025", "m/d/Y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("11.30.2025", "m.d.Y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("25-11-30", "y-m-d")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("25/11/30", "y/m/d")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("25.11.30", "y.m.d")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("30-11-25", "d-m-y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("30/11/25", "d/m/y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("30.11.25", "d.m.y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("11-30-25", "m-d-y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("11/30/25", "m/d/y")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer->fromFormatString("11.30.25", "m.d.y")->getTimestamp());
    }

    public function testDateRealtimeAsMutable()
    {
        $timestamp = strtotime(date('2025-11-30 H:i:s'));
        $sanitizer = (new DateManipulators())->setTimeToZero(false);
        $this->assertEquals($timestamp, $sanitizer("2025-11-30")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("2025/11/30")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("2025.11.30")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("30-11-2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("30/11/2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("30.11.2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("11-30-2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("11/30/2025")->getTimestamp());
        $this->assertEquals($timestamp, $sanitizer("11.30.2025")->getTimestamp());
    }

    public function testDateRealtimeAsImmutable()
    {
        $timestamp = strtotime(date('2025-11-30 H:i:s'));
        $sanitizer = (new DateManipulators())->setTimeToZero(false)->setResponseImmutable(true);
        $dates = [
            "2025-11-30",
            "2025/11/30",
            "2025.11.30",
            "30-11-2025",
            "30/11/2025",
            "30.11.2025",
            "11-30-2025",
            "11/30/2025",
            "11.30.2025",
        ];
        foreach ($dates as $date) {
            $sanitized = $sanitizer($date);
            $this->assertInstanceOf(DateTimeInterface::class, $sanitized);
            $this->assertInstanceOf(DateTimeImmutable::class, $sanitized);
            $this->assertEquals($timestamp, $sanitized->getTimestamp());
        }
    }

    public function testListOfValues()
    {
        $timestamp = strtotime('2025-11-30 00:00:00');
        $sanitizer = (new DateManipulators())->setTimeToZero(null)->setResponseImmutable(false);
        $dates = [
            "2025-11-30",
            "2025/11/30",
            "2025.11.30",
            "30-11-2025",
            "30/11/2025",
            "30.11.2025",
            "11-30-2025",
            "11/30/2025",
            "11.30.2025",
        ];
        $sanitizeds = $sanitizer(...$dates);
        foreach ($sanitizeds as $sanitized) {
            $this->assertInstanceOf(DateTimeInterface::class, $sanitized);
            $this->assertInstanceOf(DateTime::class, $sanitized);
            $this->assertEquals($timestamp, $sanitized->getTimestamp());
        }
    }
    public function testFromExcel()
    {
        $sanitizer = (new DateManipulators())->setTimeToZero(null)->setResponseImmutable(false);
        $dates = [
            "46023" => "2026-01-01",
        ];
        foreach ($dates as $xlsx_time => $date) {
            $sanitized = $sanitizer->fromExcel($xlsx_time);
            $this->assertInstanceOf(DateTimeInterface::class, $sanitized);
            $this->assertInstanceOf(DateTime::class, $sanitized);
            $this->assertEquals($date, $sanitized->format("Y-m-d"));
        }

    }
    public function testFromTimestamp()
    {
        $sanitizer = (new DateManipulators())->setTimeToZero(null)->setResponseImmutable(false);
        $dates = [
            1767225600 => "2026-01-01",
            1769904000 => "2026-02-01",
            1770681600 => "2026-02-10",
        ];
        foreach ($dates as $time => $date) {
            $sanitized = $sanitizer->fromTimestamp($time);
            $this->assertInstanceOf(DateTimeInterface::class, $sanitized);
            $this->assertInstanceOf(DateTime::class, $sanitized);
            $this->assertEquals($date, $sanitized->format("Y-m-d"));
        }
    }
    public function testFromFormatString()
    {
        $sanitizer = (new DateManipulators(new DateTimeZone("Europe/Madrid")))->setTimeToZero(true)->setResponseImmutable(false);
        $dates = [
            1767222000 => "2026-01-01",
            1769900400 => "2026-02-01",
            1770678000 => "2026-02-10",
        ];
        foreach ($dates as $time => $date) {
            $sanitized = $sanitizer->fromFormatString($date, "Y-m-d");
            $this->assertInstanceOf(DateTimeInterface::class, $sanitized);
            $this->assertInstanceOf(DateTime::class, $sanitized);
            $this->assertEquals($time, $sanitized->getTimestamp());
        }
    }
    public function testFromString()
    {
        $sanitizer = (new DateManipulators())->setTimeToZero(null)->setResponseImmutable(false);
        $dates = [
            "Thu, 01 Jan 26 00:00:00 +0000",
            "Thursday, 01-Jan-26 00:00:00 UTC",
            "2026-01-01T00:00:00.000+00:00",
            "2026-01-01T00:00:00+00:00",
            "+2026-01-01T00:00:00+00:00",
        ];
        foreach ($dates as $date) {
            $sanitized = $sanitizer->fromString($date);
            $this->assertInstanceOf(DateTimeInterface::class, $sanitized);
            $this->assertInstanceOf(DateTime::class, $sanitized);
            $this->assertEquals("2026-01-01", $sanitized->format("Y-m-d"));
        }
    }
}