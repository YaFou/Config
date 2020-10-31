<?php

namespace YaFou\Config\Loader;

class DirectoryLoader extends AbstractLoader
{
    private $directory;
    private $pattern;
    private $recursive;

    public function __construct(string $directory, array $parsers, string $pattern = '*', bool $recursive = true)
    {
        parent::__construct($parsers);
        $this->directory = $directory;
        $this->pattern = $pattern;
        $this->recursive = $recursive;
    }

    public function load(): array
    {
        $loaders = [];

        foreach (glob($this->directory . DIRECTORY_SEPARATOR . $this->pattern) as $file) {
            if (is_dir($file)) {
                if ($this->recursive) {
                    $loaders[] = new DirectoryLoader($file, $this->parsers, $this->pattern, $this->recursive);
                }

                continue;
            }

            $loaders[] = new FileLoader($file, $this->parsers);
        }

        return (new ChainLoader($loaders))->load();
    }
}
