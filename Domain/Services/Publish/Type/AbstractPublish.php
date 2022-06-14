<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

use ReflectionClass;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\ExternalBundleConfigInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\FileManagerInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\GeneratorInterface;

/**
 * Class AbstractPublish
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type
 */
abstract class AbstractPublish implements PublishInterface
{
    /**
     * @param FileManagerInterface $fileManager
     * @param GeneratorInterface $generator
     * @param ExternalBundleConfigInterface $externalBundleConfig
     */
    public function __construct(
        protected FileManagerInterface $fileManager,
        protected GeneratorInterface $generator,
        protected ExternalBundleConfigInterface $externalBundleConfig
    ) {
    }

    /**
     * @param string $bundleNameSpace
     * @param array $bundleConfig
     *
     * @return void
     */
    public function execute(string $bundleNameSpace, array $bundleConfig): void
    {
        $publishBundlePath = $this->fileManager->getPublishBundlePath(
            $bundleConfig['path'],
            $this->getPublishFromPath()
        );

        if ($this->fileManager->exists($publishBundlePath)) {
            $this->run($bundleNameSpace, $publishBundlePath, $bundleConfig);
        }
    }

    /**
     * @param string $bundleNameSpace
     * @param string $publishBundlePath
     * @param array $bundleConfig
     *
     * @return void
     */
    public function run(
        string $bundleNameSpace,
        string $publishBundlePath,
        array $bundleConfig
    ): void {
        $this->generator->simpleCopy($publishBundlePath, $this->getPublishToPath());
    }

    /**
     * @param string $bundleNameSpace
     * @param string $fileName
     *
     * @return ReflectionClass
     *
     * @throws \ReflectionException
     */
    protected function getClassReflection(
        string $bundleNameSpace,
        string $fileName
    ): ReflectionClass {
        $reflection = new ReflectionClass($bundleNameSpace);

        $namespace = $reflection->getNamespaceName() . '\\'
            . $this->getBundleNamespace() . '\\' . str_replace(
                '.php',
                '',
                $fileName
            );

        return new ReflectionClass($namespace);
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param string|null $configKey
     *
     * @return mixed
     */
    protected function getExternalConfigValue(ReflectionClass $reflectionClass, ?string $configKey = null): mixed
    {
        $configValue = $this->externalBundleConfig->get($reflectionClass->getName(), $configKey);

        if (!$configValue) {
            $configValue = $this->externalBundleConfig->get($reflectionClass->getNamespaceName(), $configKey);
        }

        return $configValue;
    }
}
