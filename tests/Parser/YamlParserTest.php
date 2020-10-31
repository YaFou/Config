<?php

namespace YaFou\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use YaFou\Config\Exception\ParseException;
use YaFou\Config\Parser\YamlParser;

class YamlParserTest extends TestCase
{
    public function testSupportedExtensions()
    {
        $this->assertSame(
            ['yaml', 'yml'],
            (new YamlParser())->getSupportedExtensions()
        );
    }

    public function testParse()
    {
        $this->assertSame(
            ['key' => 'value'],
            (new YamlParser())->parse('key: value')
        );
    }

    public function testParseThrowException()
    {
        $this->expectException(ParseException::class);
        (new YamlParser())->parse('*');
    }
}
