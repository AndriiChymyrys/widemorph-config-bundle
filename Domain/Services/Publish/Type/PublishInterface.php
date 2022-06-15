<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

/**
 * Class PublishInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type
 */
interface PublishInterface
{
    /**
     * @param string $bundleNameSpace
     * @param array $bundleConfig
     *
     * @return void
     */
    public function execute(string $bundleNameSpace, array $bundleConfig): void;

    /**
     * Get publish type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Return path where need to check publish files
     *
     * @return string
     */
    public function getPublishFromPath(): string;

    /**
     * Return path where to copy publish files
     *
     * @return string
     */
    public function getPublishToPath(): string;

    /**
     * Get name space within bundle
     *
     * @return string
     */
    public function getBundleNamespace(): string;
}
