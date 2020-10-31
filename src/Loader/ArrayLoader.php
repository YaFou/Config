<?php

namespace YaFou\Config\Loader;

class ArrayLoader implements LoaderInterface
{
    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function load(): array
    {
        return $this->configuration;
    }
}
