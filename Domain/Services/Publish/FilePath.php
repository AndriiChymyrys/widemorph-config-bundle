<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class FilePath
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
class FilePath implements FilePathInterface
{
    /**
     * @param string $rootPath
     * @param string $path
     */
    public function __construct(protected string $rootPath, protected string $path)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getRelativePath(): string
    {
        return $this->path;
    }

    /**
     * {@inheritDoc}
     */
    public function getRelativeNameSpace(): string
    {
        return str_replace('/', '\\', $this->path);
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplateNamespace(): string
    {
        $name = dirname($this->path);

        return $name === '.' ? '' : '\\' . str_replace('/', '\\', $name);
    }
}
