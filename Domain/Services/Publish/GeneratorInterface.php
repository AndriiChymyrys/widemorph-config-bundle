<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class GeneratorInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
interface GeneratorInterface
{
    /**
     * @param string $publishBundlePath
     * @param string $publishToPath
     *
     * @return void
     */
    public function simpleCopy(string $publishBundlePath, string $publishToPath): void;

    /**
     * @param string $fileName
     * @param string $publishToPath
     * @param array $vars
     * @param string $templateName
     *
     * @return void
     */
    public function generateFile(string $fileName, string $publishToPath, array $vars, string $templateName): void;
}
