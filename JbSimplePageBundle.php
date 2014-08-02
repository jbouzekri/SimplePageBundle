<?php

namespace Jb\Bundle\SimplePageBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Jb\Bundle\SimplePageBundle\DependencyInjection\Compiler\EnableDefaultEntityCompilerPass;

/**
 * JbSimplePageBundle bundle
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class JbSimplePageBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->addRegisterMappingsPass($container);
    }

    /**
     * Register model folder
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Jb\Bundle\SimplePageBundle\Model',
        );

        $container->addCompilerPass(DoctrineOrmMappingsPass::createYamlMappingDriver($mappings));
        $container->addCompilerPass(new EnableDefaultEntityCompilerPass());
    }
}
