<?php

namespace YaFou\Config\Loader;

class ChainLoader implements LoaderInterface
{
    /** @var LoaderInterface[] */
    private $loaders;

    public function __construct(array $loaders)
    {
        $this->loaders = $loaders;
    }

    public function load(): array
    {
        return array_merge(...array_map(function (LoaderInterface $loader) {
            return $loader->load();
        }, $this->loaders));
    }
}
