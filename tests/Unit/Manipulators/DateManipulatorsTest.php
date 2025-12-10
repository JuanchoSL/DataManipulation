<?php

namespace JuanchoSL\DataManipulation\Tests\Unit\Sanitizers;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use JuanchoSL\DataManipulation\Manipulators\Strings\DateManipulators;

class DateManipulatorsTest extends TestCase
{
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
        $sanitizer = (new DateManipulators())->setTimeToZero(false);
        $this->assertEquals($timestamp, $sanitizer(1764514800)->getTimestamp());
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
}