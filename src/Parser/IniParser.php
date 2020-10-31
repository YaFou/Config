<?php

namespace YaFou\Config\Parser;

use Exception;
use YaFou\Config\Exception\ParseException;

class IniParser implements ParserInterface
{
    /**
     * @param string $content
     * @return array
     * @throws ParseException
     */
    public function parse(string $content): array
    {
        try {
            $data = parse_ini_string($content);
        } catch (Exception $exception) {
            throw new ParseException(sprintf("Can't parse INI content: %s", $exception->getMessage()));
        }

        return $data;
    }

    public function getSupportedExtensions(): array
    {
        return ['ini'];
    }
}