<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

interface PublishInterface
{
    public const PUBLISH_ENTITY_NAME = 'entity';
    public const ENTITY_PUBLISH_FROM_PATH = 'Infrastructure/Entity';
    public const ENTITY_PUBLISH_TO_PATH = 'Entity';
    public const ENTITY_BUNDLE_NAMESPACE = 'Infrastructure\\Entity';

    public function execute(string $bundleNameSpace, array $bundleConfig): void;

    public function getType(): string;

    public function getPublishFromPath(): string;

    public function getPublishToPath(): string;

    public function getBundleNamespace(): string;
}
