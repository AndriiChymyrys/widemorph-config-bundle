<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

use JetBrains\PhpStorm\ArrayShape;

/**
 * Class PublishEntityService
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type
 */
class PublishEntityService extends AbstractPublish implements PublishEntityServiceInterface
{
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
        $files = $this->fileManager->scanDir($publishBundlePath);

        foreach ($files as $fileName) {
            $reflection = $this->getClassReflection(
                $bundleNameSpace,
                $fileName
            );

            $placeholders = $this->preparePlaceholders($reflection);

            $this->generator->generateFile(
                $fileName,
                $this->getPublishToPath(),
                $placeholders,
                $this->getType() . '.tpl.php'
            );
        }
    }

    public function getType(): string
    {
        return static::PUBLISH_ENTITY_NAME;
    }

    public function getPublishFromPath(): string
    {
        return static::ENTITY_PUBLISH_FROM_PATH;
    }

    public function getPublishToPath(): string
    {
        return static::ENTITY_PUBLISH_TO_PATH;
    }

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
    ])]
    protected function preparePlaceholders(\ReflectionClass $reflectionClass): array
    {
        $baseClassName = 'Base' . $reflectionClass->getShortName();
        $useStatements = [
            'use Doctrine\ORM\Mapping as ORM;',
            'use ' . $reflectionClass->getName() . ' as ' . $baseClassName . ';',
        ];

        return [
            'namespace' => 'App\\Entity',
            'useStatements' => implode(PHP_EOL, $useStatements),
            'className' => $reflectionClass->getShortName(),
            'baseClassName' => $baseClassName,
            'tableName' => $this->getTableName($reflectionClass->getShortName()),
        ];
    }

    protected function getTableName(string $name): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
    }
}
