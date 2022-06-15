<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type;

/**
 * Class PublishRepositoryServiceInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type
 */
interface PublishRepositoryServiceInterface
{
    public const PUBLISH_REPOSITORY_TYPE = 'repository';

    /** @var string */
    public const REPOSITORY_PUBLISH_FROM_PATH = 'Infrastructure/Repository';

    /** @var string */
    public const REPOSITORY_PUBLISH_TO_PATH = 'Repository';

    /** @var string */
    public const REPOSITORY_BUNDLE_NAMESPACE = 'Infrastructure\\Repository';
}
