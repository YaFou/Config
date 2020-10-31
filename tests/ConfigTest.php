<?php

namespace YaFou\Config\Tests;

use PHPUnit\Framework\TestCase;
use YaFou\Config\Config;
use YaFou\Config\Loader\ArrayLoader;

class ConfigTest extends TestCase
{
    public function testHasNot()
    {
        $config = $this->makeConfig([]);
        $this->assertFalse($config->has('key'));
    }

    private function makeConfig(array $configuration)
    {
        return new Config([new ArrayLoader($configuration)]);
    }

    public function testHasOnePartKey()
    {
        $config = $this->makeConfig(['key' => 'value']);
        $this->assertTrue($config->has('key'));
    }

    public function testHasTwoPartKey()
    {
        $config = $this->makeConfig(['key1' => ['key2' => 'value']]);
        $this->assertTrue($config->has('key1.key2'));
    }

    public function testGet()
    {
        $config = $this->makeConfig(['key' => 'value']);
        $this->assertSame('value', $config->get('key'));
    }

    public function testGetDefault()
    {
        $config = $this->makeConfig([]);
        $this->assertSame('default', $config->get('key', 'default'));
    }
}
