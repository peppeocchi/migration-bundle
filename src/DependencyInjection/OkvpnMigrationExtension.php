<?php

namespace Okvpn\Bundle\MigrationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OkvpnMigrationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');

        if ($config['migrations_table'] !== null) {
            $container->setParameter('okvpn_migration.migrations_table', $config['migrations_table']);
        }

        if ($config['migrations_path'] !== null) {
            $container->setParameter('okvpn_migration.migrations_path', $config['migrations_path']);
        }
    }
}
