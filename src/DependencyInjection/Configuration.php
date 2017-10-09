<?php

namespace Okvpn\Bundle\MigrationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('okvpn_migration')
            ->children()
                ->scalarNode('migrations_table')->end()
                ->scalarNode('migrations_path')->end()
            ->end()
        ;


        return $treeBuilder;
    }
}
