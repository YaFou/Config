<?php

namespace YaFou\Config\Parser;

use LogicException;
use Symfony\Component\Yaml\Exception\ParseException as YamlParseException;
use Symfony\Component\Yaml\Yaml;
use YaFou\Config\Exception\ParseException;

class YamlParser implements ParserInterface
{
    public function __construct()
    {
        if (!class_exists(Yaml::class)) {
            throw new LogicException('You must install "symfony/yaml" to use the YAML parser');
        }
    }

    /**
     * @param string $content
     * @return array
     * @throws ParseException
     */
    public function parse(string $content): array
    {
        try {
            return Yaml::parse($content);
        } catch (YamlParseException $exception) {
            throw new ParseException(sprintf("Can't parse YAML content: %s", $exception->getMessage()));
        }
    }

    public function getSupportedExtensions(): array
    {
        return ['yaml', 'yml'];
    }
}