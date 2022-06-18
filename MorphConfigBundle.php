<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WideMorph\Morph\Bundle\MorphConfigBundle\Infrastructure\DependencyInjection\MorphConfigExtension;

/**
 * Class MorphConfigBundle
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle
 */
class MorphConfigBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MorphConfigExtension();
    }
}
