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
     * @var array
     */
    protected array $wmBundles;

    /**
     * @param FileManagerInterface $fileManager
     * @param PublishFactoryInterface $publishFactory
     */
    public function __construct(
        protected FileManagerInterface $fileManager,
        protected PublishFactoryInterface $publishFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function crawl(): void
    {
        $this->fetchWmBundles();
        $publish = $this->publishFactory->getAll();

        foreach ($this->wmBundles as $name => $config) {
            foreach ($publish as $service) {
                $service->execute($name, $config);
            }
        }
    }

    /**
     * @return void
     */
    protected function fetchWmBundles(): void
    {
        $this->wmBundles = require $this->fileManager->getWmBundleFilePath();
    }
}
