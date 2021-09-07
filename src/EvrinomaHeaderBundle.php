<?php


namespace Evrinoma\HeaderBundle;

use Evrinoma\HeaderBundle\DependencyInjection\Compiler\HeaderPass;
use Evrinoma\HeaderBundle\DependencyInjection\EvrinomaHeaderExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class HeaderBundle
 *
 * @package Evrinoma\HeaderBundle
 */
class EvrinomaHeaderBundle extends Bundle
{
//region SECTION: Fields
    public const HEADER_BUNDLE = 'header';
//endregion Fields

//region SECTION: Getters/Setters

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new HeaderPass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaHeaderExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}