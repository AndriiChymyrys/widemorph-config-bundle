<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

use ReflectionClass;
use JetBrains\PhpStorm\ArrayShape;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\FilePathInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\ExternalBundleConfigInterface;

/**
 * Class PublishEntityService
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type
 */
class PublishEntityService extends AbstractPublish implements PublishEntityServiceInterface
{
    /**
     * {@inheritDoc}
     *
     * @throws \ReflectionException
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

        $placeholders = $this->preparePlaceholders($reflection, $filePath);

        $this->generator->generateFile(
            $filePath->getRelativePath(),
            $this->getPublishToPath(),
            $placeholders,
            $this->getType() . '.tpl.php'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): string
    {
        return static::PUBLISH_ENTITY_TYPE;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishFromPath(): string
    {
        return static::ENTITY_PUBLISH_FROM_PATH;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishToPath(): string
    {
        return static::ENTITY_PUBLISH_TO_PATH;
    }

    /**
     * {@inheritDoc}
     */
    public function getBundleNamespace(): string
    {
        return static::ENTITY_BUNDLE_NAMESPACE;
    }

    #[ArrayShape([
        'namespace' => 'string',
        'useStatements' => 'string',
        'className' => 'string',
        'baseClassName' => 'string',
        'tableName' => 'string',
        'repositoryClass' => 'string',
    ])]
    protected function preparePlaceholders(ReflectionClass $reflectionClass, FilePathInterface $filePath): array
    {
        $baseClassName = 'Base' . $reflectionClass->getShortName();
        $useStatements = [
            'use Doctrine\ORM\Mapping as ORM;',
            'use ' . $reflectionClass->getName() . ' as ' . $baseClassName . ';',
        ];

        return [
            'namespace' => 'App\\Entity' . $filePath->getTemplateNamespace(),
            'useStatements' => implode(PHP_EOL, $useStatements),
            'className' => $reflectionClass->getShortName(),
            'baseClassName' => $baseClassName,
            'tableName' => $this->getTableName($reflectionClass),
            'repositoryClass' => $this->getMetaFromClassDoc($reflectionClass, static::META_REPOSITORY_CLASS_NAME)
        ];
    }

    /**
     * @param ReflectionClass $reflectionClass
     *
     * @return string
     */
    protected function getTableName(ReflectionClass $reflectionClass): string
    {
        $tableName = $this->getExternalConfigValue(
                $reflectionClass,
                ExternalBundleConfigInterface::DB_TABLE_SETTING_NAME
            ) ?? $reflectionClass->getShortName();

        $tablePrefix = $this->getExternalConfigValue(
                $reflectionClass,
                ExternalBundleConfigInterface::DB_PREFIX_SETTING_NAME
            ) ?? '';

        $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $tableName));

        return sprintf('%s_%s', $tablePrefix, $tableName);
    }
}
