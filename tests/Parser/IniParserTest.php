<?php

namespace YaFou\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use YaFou\Config\Exception\ParseException;
use YaFou\Config\Parser\IniParser;

class IniParserTest extends TestCase
{
    public function testSupportedExtensions()
    {
        $this->assertSame(
            ['ini'],
            (new IniParser())->getSupportedExtensions()
        );
    }

    public function testParse()
    {
        $this->assertSame(
            ['key' => 'value'],
            (new IniParser())->parse('key=value')
        );
    }

    public function testParseThrowException()
    {
        $this->expectException(ParseException::class);
        (new IniParser())->parse('{');
    }
}
