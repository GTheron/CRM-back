<?php

namespace Core\RestBundle;

use Core\RestBundle\DependencyInjection\Compiler\ValidationPass;
use Doctrine\Bundle\CouchDBBundle\DependencyInjection\Compiler\DoctrineCouchDBMappingsPass;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreRestBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ValidationPass());
        $this->addRegisterMappingsPass($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__.'/Resources/config/doctrine-mapping') => 'Core\RestBundle\Model'
        );

        $container->addCompilerPass(DoctrineOrmMappingsPass::createYamlMappingDriver($mappings, array()));
    }
}
