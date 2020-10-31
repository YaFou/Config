<?php

namespace YaFou\Config\Tests\Parser;

use PHPUnit\Framework\TestCase;
use YaFou\Config\Exception\ParseException;
use YaFou\Config\Parser\PhpParser;

class PhpParserTest extends TestCase
{
    public function testSupportedExtensions()
    {
        $this->assertSame(
            ['php'],
            (new PhpParser())->getSupportedExtensions()
        );
    }

    public function testParse()
    {
        $this->assertSame(
            ['key' => 'value'],
            (new PhpParser())->parse('<?php return ["key" => "value"];')
        );
    }

    public function testParseThrowException()
    {
        $this->expectException(ParseException::class);
        (new PhpParser())->parse('<?php re');
    }
}
