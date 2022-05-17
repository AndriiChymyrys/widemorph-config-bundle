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
    public function scanDir(string $path): array
    {
        $content = array_diff(scandir($path), ['.', '..']);

        return array_filter($content, static function (string $item) use ($path) {
            return !is_dir($path . '/' . $item);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function dumpFile(string $fileName, string $content): void
    {
        $this->fileSystem->dumpFile($fileName, $content);
    }

    /**
     * {@inheritDoc}
     */
    public function getWmBundleFilePath(): string
    {
        return sprintf(
            '%s/%s',
            $this->getProjectDir(),
            static::WM_BUNDLE_FILE_PATH
        );
    }
}
