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

namespace Evrinoma\HeaderBundle;


use Evrinoma\HeaderBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\HeaderBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\HeaderBundle\DependencyInjection\Compiler\ObjectRegistryPass;
use Evrinoma\HeaderBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\HeaderBundle\DependencyInjection\EvrinomaHeaderExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class HeaderBundle.
 */
class EvrinomaHeaderBundle extends Bundle
{
    public const BUNDLE = 'header';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
            ->addCompilerPass(new ObjectRegistryPass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaHeaderExtension();
        }

        return $this->extension;
    }
}
