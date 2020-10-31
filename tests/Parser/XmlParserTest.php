<?php

namespace YaFou\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use YaFou\Config\Exception\ParseException;
use YaFou\Config\Parser\XmlParser;

class XmlParserTest extends TestCase
{
    public function testSupportedExtensions()
    {
        $this->assertSame(
            ['xml'],
            (new XmlParser())->getSupportedExtensions()
        );
    }

    public function testParse()
    {
        $this->assertSame(
            ['key' => 'value'],
            (new XmlParser())->parse('<keys><key>value</key></keys>')
        );
    }

    public function testParseThrowException()
    {
        $this->expectException(ParseException::class);
        (new XmlParser())->parse('<key');
    }
}
