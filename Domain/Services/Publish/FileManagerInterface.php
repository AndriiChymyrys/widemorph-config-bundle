<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

interface FileManagerInterface
{
    public const TEMPLATE_PATH = 'Resources/tpl';

    public function getProjectDir(): string;

    public function getPublishBundlePath(
        string $bundlePath,
        string $publishPath
    ): string;

    public function getPublishToPath(string $toPath): string;

    public function getTemplateFolder(): string;

    public function exists(string $path): bool;

    public function copyIfNotExists(string $from, string $to): void;

    public function scanDir(string $path): array;

    public function dumpFile(string $fileName, string $content): void;
}
