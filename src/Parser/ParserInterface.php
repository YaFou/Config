<?php

namespace YaFou\Config\Parser;

interface ParserInterface
{
    public function parse(string $content): array;

    public function getSupportedExtensions(): array;
}
