<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileManager
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
class FileManager implements FileManagerInterface
{
    /**
     * @param string $projectDir
     * @param Filesystem $fileSystem
     */
    public function __construct(
        protected string $projectDir,
        protected Filesystem $fileSystem
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishBundlePath(
        string $bundlePath,
        string $publishPath
    ): string {
        return sprintf(
            '%s/vendor/%s/%s',
            $this->getProjectDir(),
            $bundlePath,
            $publishPath
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplateFolder(): string
    {
        return sprintf('%s/vendor/widemorph/morph-config-bundle/%s/', $this->getProjectDir(), static::TEMPLATE_PATH);
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishToPath(string $toPath): string
    {
        return sprintf('%s/src/%s', $this->getProjectDir(), $toPath);
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishToFilePath(string $toPath, string $filePath): string
    {
        return sprintf('%s/%s', $this->getPublishToPath($toPath), $filePath);
    }

    /**
     * {@inheritDoc}
     */
    public function exists(string $path): bool
    {
        return $this->fileSystem->exists($path);
    }

    /**
     * {@inheritDoc}
     */
    public function copyIfNotExists(string $from, string $to): void
    {
        if (!$this->exists($to)) {
            $this->fileSystem->copy($from, $to);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function scanDir(string $rootPath, array $foundFiles = [], string $itemRelPath = ''): array
    {
        $paths = array_diff(scandir($rootPath), ['.', '..']);

        foreach ($paths as $item) {
            $itemPath = $rootPath . '/' . $item;

            if (is_dir($itemPath)) {
                $subFolder = $itemRelPath ? $itemRelPath . '/' . $item : $item;
                $foundFiles += $this->scanDir($itemPath, $foundFiles, $subFolder);
            } else {
                $foundFiles[] = new FilePath($rootPath, ($itemRelPath ? $itemRelPath . '/' : '') . $item);
            }
        }

        return $foundFiles;
    }

    /**
     * {@inheritDoc}
     */
    public function dumpFile(string $fileName, string $content): void
    {
        $this->fileSystem->dumpFile($fileName, $content);
    }
}
