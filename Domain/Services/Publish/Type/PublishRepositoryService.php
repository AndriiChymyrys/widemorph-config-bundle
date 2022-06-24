<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

use ReflectionClass;
use ReflectionMethod;
use ReflectionException;
use JetBrains\PhpStorm\ArrayShape;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Exception\PublishTypeException;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\FilePathInterface;

/**
 * Class PublishRepositoryService
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type
 */
class PublishRepositoryService extends AbstractPublish implements PublishRepositoryServiceInterface
{
    /**
     * {@inheritDoc}
     *
     * @throws ReflectionException|PublishTypeException
     */
    public function run(
        FilePathInterface $filePath,
        string $bundleFileNameSpace,
        string $publishBundlePath,
        array $bundleConfig
    ): void {
        $reflection = $this->getClassReflection(
            $bundleFileNameSpace,
            $filePath->getRelativeNameSpace()
        );

        $constructor = $reflection->getConstructor();

        if ($constructor) {
            [$relativeEntityName, $absolutePath] = $this->getEntityPublishPath(
                $reflection,
                $constructor,
                $bundleFileNameSpace
            );

            if ($this->fileManager->exists($absolutePath)) {
                $this->generator->generateFile(
                    $filePath->getRelativePath(),
                    $this->getPublishToPath(),
                    $this->getPlaceholders($reflection, $relativeEntityName, $filePath),
                    $this->getType() . '.tpl.php'
                );
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return static::PUBLISH_REPOSITORY_TYPE;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishFromPath(): string
    {
        return static::REPOSITORY_PUBLISH_FROM_PATH;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishToPath(): string
    {
        return static::REPOSITORY_PUBLISH_TO_PATH;
    }

    /**
     * {@inheritDoc}
     */
    public function getBundleNamespace(): string
    {
        return static::REPOSITORY_BUNDLE_NAMESPACE;
    }

    #[ArrayShape([
        'namespace' => "string",
        'className' => "string",
        'baseClassName' => "string",
        'useStatements' => "string",
        'entityName' => "false|string"
    ])]
    protected function getPlaceholders(
        ReflectionClass $reflectionClass,
        string $relativeEntityName,
        FilePathInterface $filePath
    ): array {
        $baseClassName = 'Base' . $reflectionClass->getShortName();

        $useStatements = [
            'use ' . $reflectionClass->getName() . ' as ' . $baseClassName . ';',
            'use App\\Entity\\' . $relativeEntityName . ';',
        ];

        $entityName = explode('\\', $relativeEntityName);

        return [
            'namespace' => 'App\\Repository' . $filePath->getTemplateNamespace(),
            'className' => $reflectionClass->getShortName(),
            'baseClassName' => $baseClassName,
            'useStatements' => implode(PHP_EOL, $useStatements),
            'entityName' => end($entityName)
        ];
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param ReflectionMethod $constructor
     * @param string $bundleFileNameSpace
     *
     * @return array
     *
     * @throws PublishTypeException
     * @throws ReflectionException
     */
    protected function getEntityPublishPath(
        ReflectionClass $reflectionClass,
        ReflectionMethod $constructor,
        string $bundleFileNameSpace
    ): array {
        $params = $constructor->getParameters();

        if (count($params) < 2) {
            throw new PublishTypeException(
                sprintf(
                    'Second parameter of repository constructor should be specified with default value "string $entityClass = Entity::class", Found in %s',
                    $reflectionClass->getName()
                )
            );
        }

        $entityNameSpace = $params[1]->getDefaultValue();

        $bundleReflection = new ReflectionClass($bundleFileNameSpace);
        $replacePath = sprintf(
            '%s\%s\\',
            $bundleReflection->getNamespaceName(),
            PublishEntityServiceInterface::ENTITY_BUNDLE_NAMESPACE
        );

        $relativeEntityName = str_replace($replacePath, '', $entityNameSpace);

        $absolutePath = sprintf(
            '%s/%s.php',
            $this->fileManager->getPublishToPath(
                PublishEntityServiceInterface::ENTITY_PUBLISH_TO_PATH
            ),
            str_replace('\\', '/', $relativeEntityName)
        );

        return [$relativeEntityName, $absolutePath];
    }
}
