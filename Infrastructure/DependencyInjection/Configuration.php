<?php

declare(strict_types=1);

namespace WideMorph\Morph\Bundle\MorphConfigBundle\Infrastructure\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package WideMorph\Morph\Bundle\MorphConfigBundle\Infrastructure\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('morph_config');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('publish_bundle')
                    ->useAttributeAsKey('namespace')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('namespace')->end()
                            ->scalarNode('path')->end()
                        ->end()
                    ->end()
                ->defaultValue([])
                ->end()
            ->end();

        return $treeBuilder;
    }
}
