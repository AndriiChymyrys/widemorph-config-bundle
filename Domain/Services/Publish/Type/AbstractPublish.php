<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

use ReflectionClass;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\FilePathInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\GeneratorInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\FileManagerInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\ExternalBundleConfigInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\DocBlockParserInterface;

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
     * @param DocBlockParserInterface $docBlockParser
     */
    public function __construct(
        protected FileManagerInterface $fileManager,
        protected GeneratorInterface $generator,
        protected ExternalBundleConfigInterface $externalBundleConfig,
        protected DocBlockParserInterface $docBlockParser
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
            $files = $this->fileManager->scanDir($publishBundlePath);

            foreach ($files as $filePath) {
                $absolutePath = $this->fileManager->getPublishToFilePath(
                    $this->getPublishToPath(),
                    $filePath->getRelativePath()
                );

                if (!$this->fileManager->exists($absolutePath)) {
                    $this->run($filePath, $bundleNameSpace, $publishBundlePath, $bundleConfig);
                }
            }
        }
    }

    /**
     * @param FilePathInterface $filePath
     * @param string $bundleFileNameSpace
     * @param string $publishBundlePath
     * @param array $bundleConfig
     *
     * @return void
     */
    public function run(
        FilePathInterface $filePath,
        string $bundleFileNameSpace,
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

    /**
     * @param ReflectionClass $reflectionClass
     * @param string $name
     *
     * @return null|string|bool
     */
    protected function getMetaFromClassDoc(ReflectionClass $reflectionClass, string $name): null|string|bool
    {
        $classDoc = $reflectionClass->getDocComment();

        return $this->docBlockParser->getMetaByName($classDoc, $name);
    }
}
