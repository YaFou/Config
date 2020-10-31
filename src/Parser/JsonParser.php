<?php

namespace YaFou\Config\Parser;

use YaFou\Config\Exception\ParseException;

class JsonParser implements ParserInterface
{
    /**
     * @param string $content
     * @return array
     * @throws ParseException
     */
    public function parse(string $content): array
    {
        $data = json_decode($content, true, 512);

        if (null === $data) {
            throw new ParseException(sprintf("Can't parse JSON content: %s", json_last_error_msg()));
        }

        return $data;
    }

    public function getSupportedExtensions(): array
    {
        return ['json'];
    }
}