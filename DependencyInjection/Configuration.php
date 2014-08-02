<?php

namespace Jb\Bundle\SimplePageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * JbSimplePageBundle configuration structure.
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jb_simple_page');

        $rootNode
            ->children()
                ->scalarNode('entity')
                    ->defaultValue('Jb\Bundle\SimplePageBundle\Entity\Page')
                ->end()
                ->scalarNode('provider')
                    ->validate()
                    ->ifNotInArray(array('doctrine', 'translator'))
                        ->thenInvalid('Invalid page provider : "%s"')
                    ->end()
                    ->defaultValue('doctrine')
                ->end()
                ->arrayNode('front')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('view_template')
                            ->defaultValue('JbSimplePageBundle:Front:view.html.twig')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
