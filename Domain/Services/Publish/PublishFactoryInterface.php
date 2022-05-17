<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish;

use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\Type\PublishInterface;

/**
 * Class PublishFactoryInterface
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish
 */
interface PublishFactoryInterface
{
    /**
     * @param  string  $type
     *
     * @return PublishInterface
     */
    public function getServiceByType(string $type): PublishInterface;

    /**
     * @return PublishInterface[]
     */
    public function getAll(): array;
}
