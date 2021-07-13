<?php

namespace Evrinoma\HeaderBundle\DependencyInjection\Compiler;

use Evrinoma\HeaderBundle\Manager\HeaderManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


class HeaderServicePass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(HeaderManager::class)) {
            return;
        }

        $definition = $container->findDefinition(HeaderManager::class);

        $taggedServices = $container->findTaggedServiceIds('evrinoma.service.header');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addHeaderService', [new Reference($id)]);
        }
    }
}