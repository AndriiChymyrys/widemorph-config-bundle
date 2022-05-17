<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

class BundleCrawlerService implements BundleCrawlerServiceInterface
{
    protected array $wmBundles;

    public function __construct(
        protected FileManagerInterface $fileManager,
        protected PublishFactoryInterface $publishFactory
    ) {
    }

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

    protected function fetchWmBundles(): void
    {
        $this->wmBundles = require $this->getWmBundleFilePath();
    }

    protected function getWmBundleFilePath(): string
    {
        return sprintf(
            '%s/%s',
            $this->fileManager->getProjectDir(),
            self::WM_BUNDLE_FILE_PATH
        );
    }
}
