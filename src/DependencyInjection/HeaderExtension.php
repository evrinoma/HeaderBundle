<?php


namespace Evrinoma\HeaderBundle\DependencyInjection;

use Evrinoma\HeaderBundle\HeaderBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class HeaderExtension
 *
 * @package Evrinoma\HeaderBundle\DependencyInjection
 */
class HeaderExtension extends Extension
{
//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return HeaderBundle::HEADER_BUNDLE;
    }
//endregion Getters/Setters
}