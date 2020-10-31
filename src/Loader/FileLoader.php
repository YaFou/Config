<?php

namespace YaFou\Config\Loader;

use LogicException;

class FileLoader extends AbstractLoader
{
    private $filename;

    public function __construct(string $filename, array $parsers)
    {
        parent::__construct($parsers);
        $this->filename = $filename;
    }

    public function load(): array
    {
        $content = file_get_contents($this->filename);
        $extension = pathinfo($this->filename)['extension'] ?? '';

        foreach ($this->parsers as $parser) {
            if (in_array($extension, $parser->getSupportedExtensions())) {
                return $parser->parse($content);
            }
        }

        throw new LogicException(sprintf('No parser found for "%s"', $this->filename));
    }
}
