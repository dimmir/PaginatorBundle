<?php

namespace DMR\Bundle\PaginatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $root = $treeBuilder->root('dmr_paginator');

        $root
            ->children()
                ->integerNode('items_per_page')->defaultValue(25)->end()
                ->integerNode('max_items_per_page')->defaultNull()->info('The maximum number of items per page.')->end()
                ->scalarNode('page_request_parameter_name')->defaultValue('page')->cannotBeEmpty()->end()
                ->booleanNode('client_items_per_page')->defaultFalse()->info('To allow the client to set the number of items per page.')->end()
                ->scalarNode('items_per_page_request_parameter_name')->defaultValue('itemsPerPage')->cannotBeEmpty()->end()
                ->children()
                    ->arrayNode('options')
                        ->children()
                            ->scalarNode('orm_fetch_join_collection')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
