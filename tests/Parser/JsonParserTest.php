<?php

namespace YaFou\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use YaFou\Config\Exception\ParseException;
use YaFou\Config\Parser\JsonParser;

class JsonParserTest extends TestCase
{
    public function testSupportedExtensions()
    {
        $this->assertSame(
            ['json'],
            (new JsonParser())->getSupportedExtensions()
        );
    }

    public function testParse()
    {
        $this->assertSame(
            ['key' => 'value'],
            (new JsonParser())->parse('{"key": "value"}')
        );
    }

    public function testParseThrowException()
    {
        $this->expectException(ParseException::class);
        (new JsonParser())->parse('{');
    }
}
