<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Interaction;

use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\BundleCrawlerServiceInterface;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\PublishFactoryInterface;

/**
 * Class DomainInteraction
 *
 * @package WideMorph\Morph\Bundle\Interaction
 */
class DomainInteraction implements DomainInteractionInterface
{
    /**
     * @param PublishFactoryInterface $publishFactory
     * @param BundleCrawlerServiceInterface $bundleCrawlerService
     */
    public function __construct(
        protected PublishFactoryInterface $publishFactory,
        protected BundleCrawlerServiceInterface $bundleCrawlerService
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishFactory(): PublishFactoryInterface
    {
        return $this->publishFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getBundleCrawlerService(): BundleCrawlerServiceInterface
    {
        return $this->bundleCrawlerService;
    }
}
