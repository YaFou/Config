<?php

namespace YaFou\Config;

interface ConfigInterface
{
    public function has(string $key): bool;

    public function get(string $key, $default = null);
}
