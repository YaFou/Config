<?php

namespace YaFou\Config\Parser;

use YaFou\Config\Exception\ParseException;

class XmlParser implements ParserInterface
{
    /**
     * @param string $content
     * @return array
     * @throws ParseException
     */
    public function parse(string $content): array
    {
        libxml_use_internal_errors(true);
        $element = simplexml_load_string($content);

        if (false === $element) {
            throw new ParseException(sprintf("Can't parse XML content: %s", libxml_get_last_error()->message));
        }

        return json_decode(json_encode($element), true);
    }

    public function getSupportedExtensions(): array
    {
        return ['xml'];
    }
}