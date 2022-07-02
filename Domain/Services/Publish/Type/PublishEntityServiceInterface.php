<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

/**
 * Class PublishEntityServiceInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type
 */
interface PublishEntityServiceInterface extends PublishInterface
{
    /** @var string */
    public const PUBLISH_ENTITY_TYPE = 'entity';

    /** @var string */
    public const ENTITY_PUBLISH_FROM_PATH = 'Infrastructure/Entity';

    /** @var string */
    public const ENTITY_PUBLISH_TO_PATH = 'Entity';

    /** @var string */
    public const ENTITY_BUNDLE_NAMESPACE = 'Infrastructure\\Entity';

    /** @var string */
    public const META_REPOSITORY_CLASS_NAME = 'repositoryClass';
}
