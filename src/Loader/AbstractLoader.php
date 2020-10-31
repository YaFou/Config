<?php

namespace YaFou\Config\Loader;

use YaFou\Config\Parser\ParserInterface;

abstract class AbstractLoader implements LoaderInterface
{
    /** @var ParserInterface[] */
    protected $parsers;

    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }
}
