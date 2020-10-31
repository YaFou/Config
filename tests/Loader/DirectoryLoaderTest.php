<?php

namespace YaFou\Config\Tests\Loader;

use PHPUnit\Framework\TestCase;
use YaFou\Config\Loader\DirectoryLoader;
use YaFou\Config\Parser\ParserInterface;

class DirectoryLoaderTest extends TestCase
{
    private $temporaryDirectory;

    public function testLoadNoFile()
    {
        $loader = new DirectoryLoader($this->createTemporaryDirectory('directory'), []);
        $this->assertEmpty($loader->load());
    }

    private function createTemporaryDirectory(string $directory, array $files = []): string
    {
        mkdir($this->temporaryDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'YaFou_Config_' . $directory);
        $directory = $this->temporaryDirectory . DIRECTORY_SEPARATOR;

        foreach ($files as $index => $file) {
            if (is_string($index)) {
                mkdir($directory . $index);

                foreach ($file as $subFile) {
                    touch($directory . $index . DIRECTORY_SEPARATOR . $subFile);
                }

                continue;
            }

            touch($directory . $file);
        }

        return $this->temporaryDirectory;
    }

    public function testLoadOneFile()
    {
        $directory = $this->createTemporaryDirectory('directory', ['file']);
        $loader = new DirectoryLoader($directory, [$this->makeParser(['key' => 'value'])]);
        $this->assertSame(['key' => 'value'], $loader->load());
    }

    private function makeParser(array ...$values): ParserInterface
    {
        $parser = $this->createMock(ParserInterface::class);
        $parser->method('getSupportedExtensions')->willReturn(['', 'ext']);
        $parser->method('parse')->willReturnOnConsecutiveCalls(...$values);

        return $parser;
    }

    public function testLoadTwoFiles()
    {
        $directory = $this->createTemporaryDirectory('directory', ['file1', 'file2']);

        $loader = new DirectoryLoader($directory, [$this->makeParser(
            ['key1' => 'value1'],
            ['key2' => 'value2']
        )]);

        $this->assertSame([
            'key1' => 'value1',
            'key2' => 'value2'
        ], $loader->load());
    }

    public function testLoadTwoFilesWithPattern()
    {
        $directory = $this->createTemporaryDirectory('directory', ['file1', 'file2.ext']);
        $loader = new DirectoryLoader($directory, [$this->makeParser(['key' => 'value2'])], '*.ext');
        $this->assertSame(['key' => 'value2'], $loader->load());
    }

    public function testLoadTwoFilesWithRecursive()
    {
        $directory = $this->createTemporaryDirectory(
            'directory',
            ['file1', 'sub_directory' => ['file2', 'file3']]
        );

        $loader = new DirectoryLoader($directory, [$this->makeParser(
            ['key1' => 'value1'],
            ['key2' => 'value2'],
            ['key3' => 'value3']
        )]);

        $this->assertSame([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3'
        ], $loader->load());
    }

    public function testLoadTwoFilesWithoutRecursive()
    {
        $directory = $this->createTemporaryDirectory(
            'directory',
            ['file1', 'sub_directory' => ['file2', 'file3']]
        );

        $loader = new DirectoryLoader($directory, [$this->makeParser(['key1' => 'value1'])], '*', false);
        $this->assertSame(['key1' => 'value1'], $loader->load());
    }

    protected function tearDown(): void
    {
        if (null !== $this->temporaryDirectory) {
            foreach (glob($this->temporaryDirectory . DIRECTORY_SEPARATOR . '*') as $file) {
                if (is_dir($file)) {
                    foreach (glob($file . DIRECTORY_SEPARATOR . '*') as $subFile) {
                        unlink($subFile);
                    }

                    rmdir($file);
                    continue;
                }

                unlink($file);
            }

            rmdir($this->temporaryDirectory);
        }
    }
}
