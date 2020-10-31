<?php

namespace YaFou\Config\Tests\Loader;

use LogicException;
use PHPUnit\Framework\TestCase;
use YaFou\Config\Loader\FileLoader;
use YaFou\Config\Parser\ParserInterface;

class FileLoaderTest extends TestCase
{
    private $temporaryFile;

    public function testNoParserFound()
    {
        $this->expectException(LogicException::class);
        $loader = new FileLoader($this->createTemporaryFile('file'), []);
        $loader->load();
    }

    private function createTemporaryFile(string $filename)
    {
        touch($this->temporaryFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'YaFou_Config_' . $filename);

        return $this->temporaryFile;
    }

    public function testLoad()
    {
        $parser = $this->createMock(ParserInterface::class);
        $parser->expects($this->once())->method('getSupportedExtensions')->willReturn(['']);
        $parser->expects($this->once())->method('parse')->willReturn(['key' => 'value']);

        $loader = new FileLoader(
            $this->createTemporaryFile('file'),
            [$parser]
        );

        $this->assertSame(['key' => 'value'], $loader->load());
    }

    protected function tearDown(): void
    {
        if (null !== $this->temporaryFile) {
            unlink($this->temporaryFile);
        }
    }
}
