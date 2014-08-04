<?php

namespace Jb\Bundle\SimplePageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;

/**
 * JbSimplePage extension
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class JbSimplePageExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('controllers.yml');
        $loader->load('services.yml');

        $config = $this->processConfiguration(new Configuration(), $configs);
        $this->loadConfiguration($container, $config);
    }

    /**
     * Load configuration
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param array $config
     */
    protected function loadConfiguration(ContainerBuilder $container, array $config)
    {
        $container->setParameter('jb_simple_page.entity.class', $config['entity']);
        $container->setParameter('jb_simple_page.front.view_template', $config['front']['view_template']);
        $container->setParameter('jb_simple_page.admin.templates', $config['admin']);
        $container->setParameter('jb_simple_page.form.type', $config['form']);
        $container->setParameter(
            'jb_simple_page.translator.translation_domain',
            $config['translator']['translation_domain']
        );
        $container->setParameter(
            'jb_simple_page.translator.pages',
            $config['translator']['pages']
        );

        $providerDefinition = $container->getDefinition('jb_simple_page.page.provider.'.$config['provider']);
        $container->getDefinition('jb_simple_page.front.controller')->replaceArgument(0, $providerDefinition);
        $container->getDefinition('jb_simple_page.admin.controller')->replaceArgument(0, $providerDefinition);

        if (strpos($config['entity'], 'Jb\Bundle\SimplePageBundle') === 0) {
            $container->setParameter('jb_simple_page.entity.enable_default', true);
        }
    }
}
