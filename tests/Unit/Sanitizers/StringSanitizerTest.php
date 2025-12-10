<?php

namespace JuanchoSL\DataManipulation\Tests\Unit\Sanitizers;

use PHPUnit\Framework\TestCase;
use JuanchoSL\DataManipulation\Sanitizers\Strings\StringSanitizers;
use JuanchoSL\DataManipulation\Sanitizers\Strings\ExtendedStringSanitizers;

class StringSanitizerTest extends TestCase
{

    public function testStringSanitizerTrue()
    {
        $this->assertEquals("&#60;div&#62;Text&#60;/div&#62;", (new ExtendedStringSanitizers())->htmlEncode()->__invoke('<div>Text</div>'));
        $this->assertEquals("&#60;div&#62;Text&#60;/div&#62;", (new ExtendedStringSanitizers())->setStripChars(true)->htmlEncode()->__invoke("<div>Text\r\n</div>"));
        $this->assertEquals('&#60;div&#62;Text&#13;&#10;&#60;/div&#62;', (new ExtendedStringSanitizers())->setStripChars(false)->htmlEncode()->__invoke("<div>Text\r\n</div>"));
        $this->assertEquals('&#60;div&#62;Text&#13;&#10;&#60;/div&#62;', (new ExtendedStringSanitizers())->setEncodeChars(true)->htmlEncode()->__invoke("<div>Text\r\n</div>"));
        $this->assertEquals('&#60;div&#62;Text&#13;&#10;&#60;/div&#62;', (new ExtendedStringSanitizers())->setEncodeChars(false)->htmlEncode()->__invoke("<div>Text\r\n</div>"));
        $this->assertEquals("&#60;div&#62;Téxt&#60;/div&#62;", (new ExtendedStringSanitizers())->setStripChars(true, false)->htmlEncode()->__invoke("<div>Téxt\r\n</div>"));
        $this->assertEquals('&#60;div&#62;Txt&#13;&#10;&#60;/div&#62;', (new ExtendedStringSanitizers())->setStripChars(false, true)->htmlEncode()->__invoke("<div>Téxt\r\n</div>"));
        $this->assertEquals('&#60;div&#62;T&#195;&#169;xt&#13;&#10;&#60;/div&#62;', (new ExtendedStringSanitizers())->setEncodeChars(true, true)->htmlEncode()->__invoke("<div>Téxt\r\n</div>"));
        $this->assertEquals('&#60;div&#62;Téxt&#13;&#10;&#60;/div&#62;', (new ExtendedStringSanitizers())->setEncodeChars(false, false)->htmlEncode()->__invoke("<div>Téxt\r\n</div>"));
        
        $this->assertEquals("SELECT * FROM `table`", (new ExtendedStringSanitizers())->setStripBacktick(false)->safe()->__invoke("SELECT * FROM `table`"));
        $this->assertEquals("SELECT * FROM table", (new ExtendedStringSanitizers())->setStripBacktick(true)->safe()->__invoke("SELECT * FROM `table`"));
        $this->assertEquals("SELECT * FROM `table`", (new ExtendedStringSanitizers())->setStripBacktick(false)->unsafe()->__invoke("SELECT * FROM `table`"));
        $this->assertEquals("SELECT * FROM table", (new ExtendedStringSanitizers())->setStripBacktick(true)->unsafe()->__invoke("SELECT * FROM `table`"));
        $this->assertEquals("SELECT * FROM `table`", (new ExtendedStringSanitizers())->setStripBacktick(false)->addSlashes()->__invoke("SELECT * FROM `table`"));
        $this->assertEquals("SELECT * FROM `table`", (new ExtendedStringSanitizers())->setStripBacktick(true)->addSlashes()->__invoke("SELECT * FROM `table`"));

        $this->assertEquals('&lt;div&gt;Text&lt;/div&gt;', (new StringSanitizers())->htmlSpecialChars()->__invoke('<div>Text</div>'));
        $this->assertEquals("&lt;div&gt;Text\r\n&lt;/div&gt;", (new StringSanitizers())->htmlSpecialChars()->__invoke("<div>Text\r\n</div>"));
        $this->assertEquals("&lt;div&gt;Text\r\n&lt;/div&gt;", (new StringSanitizers())->htmlSpecialChars(false)->__invoke("<div>Text\r\n</div>"));

        $this->assertEquals('Text', (new StringSanitizers())->stripTags()->__invoke('<div>Text</div>'));
        $this->assertEquals("Text\r\n", (new StringSanitizers())->stripTags()->__invoke("<div>Text\r\n</div>"));
        $this->assertEquals("Camión&\r\n", (new StringSanitizers())->stripTags()->__invoke("<div>Camión&\r\n</div>"));
        $this->assertEquals("Cami&oacute;n&amp;\r\n", (new StringSanitizers())->stripTags()->htmlSpecialChars()->__invoke("<div>Camión&\r\n</div>"));

        $this->assertEquals("SELECT * FROM `table`", (new StringSanitizers())->addSlashes()->__invoke("SELECT * FROM `table`"));
        $this->assertEquals("SELECT * FROM \'table\'", (new StringSanitizers())->addSlashes()->__invoke("SELECT * FROM 'table'"));
        $this->assertEquals('SELECT * FROM \"table\"', (new StringSanitizers())->addSlashes()->__invoke('SELECT * FROM "table"'));
    }
}