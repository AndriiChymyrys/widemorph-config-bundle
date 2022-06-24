<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Tests\Unit\Domain\Services\Publish;

use PHPUnit\Framework\TestCase;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\FileManagerInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\FilePath;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Generator;

/**
 * Class GeneratorTest
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Tests\Unit\Domain\Services\Publish
 */
class GeneratorTest extends TestCase
{
    public function testSimpleCopy()
    {
        $fileManager = $this->createMock(FileManagerInterface::class);
        $filePath = new FilePath('/var/www/', 'File/Name.php');

        $fileManager
            ->expects($this->once())
            ->method('getPublishToPath')
            ->with('src/Entity')
            ->willReturn('/var/www/src/Entity');

        $fileManager
            ->expects($this->once())
            ->method('scanDir')
            ->with('vendor/morph/Infrastructure/Entity')
            ->willReturn([
                $filePath
            ]);

        $fileManager
            ->expects($this->once())
            ->method('copyIfNotExists')
            ->with('vendor/morph/Infrastructure/Entity/File/Name.php', '/var/www/src/Entity/File/Name.php');

        $generator = new Generator($fileManager);

        $generator->simpleCopy('vendor/morph/Infrastructure/Entity', 'src/Entity');
    }

    public function testGenerateFile()
    {
        $fileManager = $this->createMock(FileManagerInterface::class);

        $fileManager
            ->expects($this->once())
            ->method('getTemplateFolder')
            ->willReturn('/var/www/vendor/Resources/tpl/');

        $fileManager
            ->expects($this->once())
            ->method('getPublishToPath')
            ->with('Entity')
            ->willReturn('/var/www/src/Entity');

        $fileManager
            ->expects($this->once())
            ->method('dumpFile')
            ->with('/var/www/src/Entity/fileName.php', 'File content');

        $generator = $this->getMockBuilder(Generator::class)
            ->setConstructorArgs([$fileManager])
            ->onlyMethods(['getFileContent'])
            ->getMock();

        $generator
            ->expects($this->once())
            ->method('getFileContent')
            ->with(['var' => 'val'], '/var/www/vendor/Resources/tpl/entity.tpl.php')
            ->willReturn('File content');

        $generator->generateFile('fileName.php', 'Entity', ['var' => 'val'], 'entity.tpl.php');
    }
}
