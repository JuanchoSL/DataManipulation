<?php

namespace JuanchoSL\DataManipulation\Tests\Unit\Manipulators;

use JuanchoSL\DataManipulation\Manipulators\Strings\StringsManipulators;
use PHPUnit\Framework\TestCase;

class StringManipulatorsTest extends TestCase
{
    public function testCase()
    {
        $string = new StringsManipulators("juan sanchez lecegui");
        $this->assertEquals("Juan Sanchez Lecegui", (string) $string = $string->toUpperWords());
        $this->assertEquals("JUAN SANCHEZ LECEGUI", (string) $string = $string->toUpper());
        $this->assertEquals("jUAN SANCHEZ LECEGUI", (string) $string = $string->toLowerFirst());
        $this->assertEquals("juan sanchez lecegui", (string) $string = $string->toLower());
    }
    public function testPreppendAppend()
    {
        $string = new StringsManipulators("sanchez");
        $this->assertEquals("sanchez lecegui", (string) $string = $string->concatenation('lecegui'));
        $this->assertEquals("juan sanchez lecegui", (string) $string = $string->preppend('juan'));
    }
    public function testFormat()
    {
        $string = new StringsManipulators("%s %s %s");
        $this->assertEquals("juan sanchez lecegui", (string) $string = $string->format('juan', 'sanchez', 'lecegui'));
    }
    public function testReplace()
    {
        $string = new StringsManipulators("juan sanchez lecegui");
        $this->assertEquals("juan sánchez lecegui", (string) $string = $string->replace('sanchez', 'sánchez'));
    }
    public function testSubstring()
    {
        $string = new StringsManipulators("juan sánchez lecegui");
        $this->assertEquals("sánchez", (string) $string = $string->substring(5, mb_strlen('sánchez')));
    }
    public function testRepeat()
    {
        $string = new StringsManipulators("*");
        $this->assertEquals("**********", (string) $string = $string->repeat(10));
        $string = new StringsManipulators("**");
        $this->assertEquals("**********", (string) $string = $string->repeat(5));
    }
    public function testReverse()
    {
        $string = new StringsManipulators("abcdef");
        $this->assertEquals("fedcba", (string) $string = $string->reverse());
    }
    public function testShuffle()
    {
        $string = new StringsManipulators("abcdef");
        $this->assertNotEquals("abcdef", (string) $string = $string->shuffle());
    }
    public function testRotate()
    {
        $string = new StringsManipulators("abcdef");
        $this->assertNotEquals("abcdef", (string) $string = $string->rotate13());
        $this->assertEquals("abcdef", (string) $string = $string->rotate13());
    }
    public function testCharset()
    {
        $string = new StringsManipulators("camión");
        $this->assertNotEquals("camión", (string) $string1 = $string->convertEncoding("UTF-7"));
        $this->assertEquals("camión", (string) $string = $string1->convertEncoding('UTF-8'));
    }
    public function testQP()
    {
        $string = new StringsManipulators("àèìòù");
        $this->assertNotEquals("àèìòù", (string) $string = $string->quotedPrintableEncode());
        $this->assertEquals("àèìòù", (string) $string = $string->quotedPrintableDecode());
    }
    public function testBase64()
    {
        $string = new StringsManipulators("àèìòù");
        $this->assertNotEquals("àèìòù", (string) $string = $string->base64Encode());
        $this->assertEquals("àèìòù", (string) $string = $string->base64Decode());
    }
    public function testUU()
    {
        $string = new StringsManipulators("àèìòù");
        $this->assertNotEquals("àèìòù", (string) $string = $string->uuEncode());
        $this->assertEquals("àèìòù", (string) $string = $string->uuDecode());
    }

    public function testUrl()
    {
        $string = new StringsManipulators("parametro1=camión");
        $this->assertNotEquals("parametro1=camión", (string) $string = $string->urlEncode());
        $this->assertEquals("parametro1=camión", (string) $string = $string->urlDecode());
    }
    public function testHex()
    {
        $string = new StringsManipulators("àèìòù");
        $this->assertNotEquals("àèìòù", (string) $string = $string->binToHex());
        $this->assertEquals("àèìòù", (string) $string = $string->hexToBin());
    }
    public function testPadding()
    {
        $string = new StringsManipulators("abcde€");
        $this->assertEquals("----abcde€", (string) $string->padding(10, '-', STR_PAD_LEFT));
        $this->assertEquals("abcde€----", (string) $string->padding(10, '-', STR_PAD_RIGHT));
    }
    public function testTrim()
    {
        $string = new StringsManipulators(" abcde ");
        $this->assertEquals("abcde", (string) $string->trim());
        $this->assertEquals("abcde ", (string) $string->ltrim());
        $this->assertEquals(" abcde", (string) $string->rtrim());
    }
    public function testMd5()
    {
        $string = new StringsManipulators("abcde");
        $this->assertEquals(32, strlen((string) $string = $string->md5()));
    }
    public function testChunk()
    {
        $string = new StringsManipulators("abcdefghijklmnñopqrstuvwxyz");
        $this->assertEquals("abcdefghij\r\nklmnñopqrs\r\ntuvwxyz", (string) $string = $string->chunk(10));
    }

    public function testWordWrap()
    {
        $string = new StringsManipulators("juan sanchez lecegui");
        $this->assertEquals("juan\r\nsanchez\r\nlecegui", (string) $string->wordWrap(10, "\r\n"));
        $this->assertEquals("juan\r\nsanchez\r\nlecegui", (string) $string = $string->wordWrap(10, "\r\n", true));
        $this->assertEquals("juan\r\nsanch\r\nez\r\nleceg\r\nui", (string) $string = $string->wordWrap(5, "\r\n", true));
    }

    public function testEOL()
    {
        $strings = [
            "juan\r\nsanchez\r\nlecegui",
            "juan\rsanchez\rlecegui",
            "juan\nsanchez\nlecegui",
        ];

        foreach ($strings as $string) {
            $string = new StringsManipulators($string);
            $this->assertEquals("juan\r\nsanchez\r\nlecegui", (string) $string->eol("\r\n"));
            $this->assertEquals("juan\rsanchez\rlecegui", (string) $string->eol("\r"));
            $this->assertEquals("juan\nsanchez\nlecegui", (string) $string->eol("\n"));
        }
    }
}