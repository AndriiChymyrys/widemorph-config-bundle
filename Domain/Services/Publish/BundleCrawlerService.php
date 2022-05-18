<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class BundleCrawlerService
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
class BundleCrawlerService implements BundleCrawlerServiceInterface
{
    /**
     * @param array $wmBundles
     * @param FileManagerInterface $fileManager
     * @param PublishFactoryInterface $publishFactory
     */
    public function __construct(
        protected array $wmBundles,
        protected FileManagerInterface $fileManager,
        protected PublishFactoryInterface $publishFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function crawl(): void
    {
        $publish = $this->publishFactory->getAll();

        foreach ($this->wmBundles as $namespace => $config) {
            foreach ($publish as $service) {
                $service->execute($namespace, $config);
            }
        }
    }
}
