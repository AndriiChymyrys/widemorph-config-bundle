<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

use Symfony\Component\Filesystem\Filesystem;

class FileManager implements FileManagerInterface
{
    public function __construct(
        protected string $projectDir,
        protected Filesystem $fileSystem
    ) {
    }

    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

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

    public function getTemplateFolder(): string
    {
        return sprintf('%s/vendor/widemorph/morph-config-bundle/%s/', $this->getProjectDir(), static::TEMPLATE_PATH);
    }

    public function getPublishToPath(string $toPath): string
    {
        return sprintf('%s/src/%s', $this->getProjectDir(), $toPath);
    }

    public function exists(string $path): bool
    {
        return $this->fileSystem->exists($path);
    }

    public function copyIfNotExists(string $from, string $to): void
    {
        if (!$this->exists($to)) {
            $this->fileSystem->copy($from, $to);
        }
    }

    public function scanDir(string $path): array
    {
        $content = array_diff(scandir($path), ['.', '..']);

        return array_filter($content, static function (string $item) use ($path) {
            return !is_dir($path . '/' . $item);
        });
    }

    public function dumpFile(string $fileName, string $content): void
    {
        $this->fileSystem->dumpFile($fileName, $content);
    }
}
