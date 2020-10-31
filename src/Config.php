<?php

namespace YaFou\Config;

use YaFou\Config\Loader\ChainLoader;

class Config implements ConfigInterface
{
    private $configuration;
    private $resolvedEntries = [];

    public function __construct(array $loaders)
    {
        $this->configuration = (new ChainLoader($loaders))->load();
    }

    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->resolvedEntries[$key];
        }

        return $default;
    }

    public function has(string $key): bool
    {
        if (isset($this->resolvedEntries[$key])) {
            return true;
        }

        $parts = explode('.', $key);
        $root = $this->configuration;

        foreach ($parts as $part) {
            if (!isset($root[$part])) {
                return false;
            }

            $root = $root[$part];
        }

        $this->resolvedEntries[$key] = $root;

        return true;
    }
}
