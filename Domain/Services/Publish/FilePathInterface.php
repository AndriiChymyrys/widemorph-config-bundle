<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class FilePathInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
interface FilePathInterface
{
    /**
     * @return string
     */
    public function getRelativePath(): string;

    /**
     * @return string
     */
    public function getRelativeNameSpace(): string;

    /**
     * @return string
     */
    public function getTemplateNamespace(): string;
}
