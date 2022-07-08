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
                    $this->getPlaceholders($reflection, $relativeEntityName, $filePath, $constructor),
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
        'entityName' => "false|string",
        'arguments' => "string",
        'parentArguments' => "string",
    ])]
    protected function getPlaceholders(
        ReflectionClass $reflectionClass,
        string $relativeEntityName,
        FilePathInterface $filePath,
        ReflectionMethod $constructor
    ): array {
        $baseClassName = 'Base' . $reflectionClass->getShortName();

        $useStatements = [
            'use ' . $reflectionClass->getName() . ' as ' . $baseClassName . ';',
            'use App\\Entity\\' . $relativeEntityName . ';',
        ];

        $entityName = explode('\\', $relativeEntityName);

        [$use, $params] = $this->getArguments($constructor);
        $useStatements = array_merge($useStatements, $use);

        return [
            'namespace' => 'App\\Repository' . $filePath->getTemplateNamespace(),
            'className' => $reflectionClass->getShortName(),
            'baseClassName' => $baseClassName,
            'useStatements' => implode(PHP_EOL, $useStatements),
            'entityName' => end($entityName),
            'arguments' => implode(', ', array_values($params)),
            'parentArguments' => implode(', ', array_keys($params)),
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
        $entityNameSpace = null;

        foreach ($params as $param) {
            if ($param->getName() === static::ENTITY_CLASS_REPOSITORY_PARAMETER_NAME) {
                $entityNameSpace = $param->getDefaultValue();
            }
        }

        if (!$entityNameSpace) {
            throw new PublishTypeException(
                sprintf(
                    'Required parameter for repository class is "%s", found in "%s"',
                    static::ENTITY_CLASS_REPOSITORY_PARAMETER_NAME,
                    $reflectionClass->getName()
                )
            );
        }

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

    /**
     * @param ReflectionMethod $constructor
     *
     * @return array
     */
    protected function getArguments(ReflectionMethod $constructor): array
    {
        $use = [];
        $params = [];

        foreach ($constructor->getParameters() as $param) {
            if ($param->getName() === static::ENTITY_CLASS_REPOSITORY_PARAMETER_NAME) {
                continue;
            }

            $type = $param->getType();
            $names = explode('\\', $type->getName());
            $varName = '$' . $param->getName();
            $params[$varName] = sprintf('%s %s' , $names[array_key_last($names)], $varName);

            $use[] = 'use ' . $type->getName() . ';';
        }

        return [$use, $params];
    }
}
