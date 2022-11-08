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

namespace Evrinoma\HeaderBundle\DependencyInjection;

use Evrinoma\HeaderBundle\EvrinomaHeaderBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaHeaderBundle::BUNDLE);
        $rootNode = $treeBuilder->getRootNode();

        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaHeaderExtension::ENTITY_FACTORY_HEADER)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaHeaderExtension::ENTITY_BASE_HEADER)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used to enable/disable basic header constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaHeaderExtension::DTO_BASE_HEADER)->info('This option is used to dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used to command header decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used to query header decoration')->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used to pre_validator overriding')->end()
            ->scalarNode('handler')->cannotBeEmpty()->defaultValue(EvrinomaHeaderExtension::HANDLER)->info('This option is used to handler override')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
