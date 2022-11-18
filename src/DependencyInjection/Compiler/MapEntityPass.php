<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\HeaderBundle\DependencyInjection\Compiler;

use Evrinoma\HeaderBundle\DependencyInjection\EvrinomaHeaderExtension;
use Evrinoma\HeaderBundle\Model\Header\HeaderInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ('orm' === $container->getParameter('evrinoma.header.storage')) {
            $this->setContainer($container);

            $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
            $referenceAnnotationReader = new Reference('annotations.reader');

            $this->cleanMetadata($driver, [EvrinomaHeaderExtension::ENTITY]);

            $entityHeader = $container->getParameter('evrinoma.header.entity');
            if (str_contains($entityHeader, EvrinomaHeaderExtension::ENTITY)) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Header', '%s/Entity/Header');
            }
            $this->addResolveTargetEntity([$entityHeader => [HeaderInterface::class => []]], false);
        }
    }
}
