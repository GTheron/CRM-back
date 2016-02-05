<?php

namespace Core\RestBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
class ValidationPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('core_rest.storage_types')) {
            return;
        }
        $storages = $container->getParameter('core_rest.storage_types');

        $validationFiles = array();
        foreach($storages as $storage)
            $validationFiles[] = __DIR__ . '/../../Resources/config/storage-validation/' . $storage . '.yml';

        // Symfony 2.5+
        $container->getDefinition('validator.builder')
            ->addMethodCall('addYamlMapping', $validationFiles);
    }
}