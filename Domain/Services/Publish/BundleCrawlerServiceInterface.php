<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

interface BundleCrawlerServiceInterface
{
    public const WM_BUNDLE_FILE_PATH = 'config/wm_bundles.php';

    public function crawl(): void;
}
