<?php


namespace Evrinoma\HeaderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Evrinoma\HeaderBundle\EvrinomaHeaderBundle;

/**
 * Class Configuration
 *
 * @package Evrinoma\HeaderBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
//region SECTION: Getters/Setters
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder      = new TreeBuilder(EvrinomaHeaderBundle::HEADER_BUNDLE);
        $rootNode         = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
//endregion Getters/Setters
}
