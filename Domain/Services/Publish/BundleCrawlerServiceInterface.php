<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

/**
 * Class BundleCrawlerServiceInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
interface BundleCrawlerServiceInterface
{
    /**
     * @return void
     */
    public function crawl(): void;

    /**
     * @param string $type
     *
     * @return void
     */
    public function crawlType(string $type): void;
}
