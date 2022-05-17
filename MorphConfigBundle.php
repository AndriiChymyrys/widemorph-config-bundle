<?php

namespace WideMorph\Morph\Bundle\MorphConfigBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WideMorph\Morph\Bundle\MorphConfigBundle\Infrastructure\DependencyInjection\MorphConfigExtension;

class MorphConfigBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MorphConfigExtension();
    }
}
