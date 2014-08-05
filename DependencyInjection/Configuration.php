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
                ->scalarNode('form')
                    ->defaultValue('jb_simple_page_default_form')
                ->end()
                ->arrayNode('router')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('root_prefix')
                            ->defaultValue('page')
                        ->end()
                        ->scalarNode('admin_prefix')
                            ->defaultValue('admin')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('translator')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('translation_domain')
                            ->defaultValue('jb_simple_page')
                        ->end()
                        ->arrayNode('pages')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('front')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('view_template')
                            ->defaultValue('JbSimplePageBundle:Front:view.html.twig')
                        ->end()
                        ->scalarNode('layout_template')
                            ->defaultValue('::base.html.twig')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('admin')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('index_template')
                            ->defaultValue('JbSimplePageBundle:Admin:index.html.twig')
                        ->end()
                        ->scalarNode('edit_template')
                            ->defaultValue('JbSimplePageBundle:Admin:edit.html.twig')
                        ->end()
                        ->scalarNode('layout_template')
                            ->defaultValue('::base.html.twig')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
