<?php

namespace YaFou\Config\Parser;

use ParseError;
use YaFou\Config\Exception\ParseException;

class PhpParser implements ParserInterface
{
    /**
     * @param string $content
     * @return array
     * @throws ParseException
     */
    public function parse(string $content): array
    {
        try {
            return eval('?>' . $content);
        } catch (ParseError $exception) {
            throw new ParseException(sprintf("Can't parse PHP content: %s", $exception->getMessage()));
        }
    }

    public function getSupportedExtensions(): array
    {
        return ['php'];
    }
}
