<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Infrastructure\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use WideMorph\Morph\Bundle\MorphConfigBundle\Domain\Services\Publish\BundleCrawlerService;

/**
 * Class MorphConfigExtension
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Infrastructure\DependencyInjection
 */
class MorphConfigExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../Resources/config')
        );

        $loader->load('interaction.xml');
        $loader->load('infrastructure.xml');
        $loader->load('domain.xml');
        $loader->load('services.xml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition(BundleCrawlerService::class);
        $definition->replaceArgument('$wmBundles', $config['publish_bundle']);
    }
}
