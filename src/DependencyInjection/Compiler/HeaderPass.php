<?php

namespace Evrinoma\HeaderBundle\DependencyInjection\Compiler;

use Evrinoma\HeaderBundle\Repository\HeaderRepository;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


class HeaderPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(HeaderRepository::class)) {
            return;
        }

        $definition = $container->findDefinition(HeaderRepository::class);

        $taggedServices = $container->findTaggedServiceIds('evrinoma.header');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addHeader', [new Reference($id)]);
        }
    }
}