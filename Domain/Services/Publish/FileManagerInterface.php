<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class FileManagerInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
interface FileManagerInterface
{
    /** @var string */
    public const TEMPLATE_PATH = 'Resources/tpl';

    /**
     * @return string
     */
    public function getProjectDir(): string;

    /**
     * @param string $bundlePath
     * @param string $publishPath
     *
     * @return string
     */
    public function getPublishBundlePath(
        string $bundlePath,
        string $publishPath
    ): string;

    /**
     * @param string $toPath
     *
     * @return string
     */
    public function getPublishToPath(string $toPath): string;

    /**
     * @param string $toPath
     * @param string $filePath
     *
     * @return string
     */
    public function getPublishToFilePath(string $toPath, string $filePath): string;

    /**
     * @return string
     */
    public function getTemplateFolder(): string;

    /**
     * @param string $path
     *
     * @return bool
     */
    public function exists(string $path): bool;

    /**
     * @param string $from
     * @param string $to
     *
     * @return void
     */
    public function copyIfNotExists(string $from, string $to): void;

    /**
     * @param string $rootPath
     * @param array $foundFiles
     * @param string $itemRelPath
     *
     * @return FilePathInterface[]
     */
    public function scanDir(string $rootPath, array $foundFiles = [], string $itemRelPath = ''): array;

    /**
     * @param string $fileName
     * @param string $content
     *
     * @return void
     */
    public function dumpFile(string $fileName, string $content): void;
}
