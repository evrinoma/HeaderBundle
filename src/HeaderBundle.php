<?php


namespace Evrinoma\HeaderBundle;

use Evrinoma\HeaderBundle\DependencyInjection\HeaderExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class HeaderBundle
 *
 * @package Evrinoma\HeaderBundle
 */
class HeaderBundle extends Bundle
{
//region SECTION: Fields
    public const HEADER_BUNDLE = 'header';
//endregion Fields

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new HeaderExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}