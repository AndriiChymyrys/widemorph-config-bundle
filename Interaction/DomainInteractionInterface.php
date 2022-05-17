<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Interaction;

use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\BundleCrawlerServiceInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\PublishFactoryInterface;

/**
 * Class DomainInteractionInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Interaction
 */
interface DomainInteractionInterface
{
    /**
     * @return PublishFactoryInterface
     */
    public function getPublishFactory(): PublishFactoryInterface;

    /**
     * @return BundleCrawlerServiceInterface
     */
    public function getBundleCrawlerService(): BundleCrawlerServiceInterface;
}
