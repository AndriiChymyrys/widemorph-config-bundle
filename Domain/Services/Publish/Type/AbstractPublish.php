<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

use ReflectionClass;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\FileManagerInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\GeneratorInterface;

abstract class AbstractPublish implements PublishInterface
{
    public function __construct(protected FileManagerInterface $fileManager, protected GeneratorInterface $generator)
    {
    }

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

    public function run(
        string $bundleNameSpace,
        string $publishBundlePath,
        array $bundleConfig
    ): void {
        $this->generator->simpleCopy($publishBundlePath, $this->getPublishToPath());
    }

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
}
