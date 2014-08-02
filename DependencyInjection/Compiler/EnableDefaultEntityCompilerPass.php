<?php

namespace Jb\Bundle\SimplePageBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

/**
 * Description of EnableDefaultEntityCompilerPass
 *
 * @author jobou
 */
class EnableDefaultEntityCompilerPass implements CompilerPassInterface
{
    /**
     * Enable default page entity if needed
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('jb_simple_page.entity.enable_default')) {
            return;
        }

        $mappings = array(
            realpath(__DIR__ . '/../../Resources/config/doctrine/default') => 'Jb\Bundle\SimplePageBundle\Entity',
        );

        $defaultEntityPass = DoctrineOrmMappingsPass::createYamlMappingDriver($mappings);
        $defaultEntityPass->process($container);
    }
}
