<?php

namespace Okvpn\Bundle\MigrationBundle\EventListener;

use Okvpn\Bundle\MigrationBundle\Event\PreMigrationEvent;
use Okvpn\Bundle\MigrationBundle\Migration\CreateMigrationTableMigration;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PreUpMigrationListener
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param PreMigrationEvent $event
     */
    public function onPreUp(PreMigrationEvent $event)
    {
        $table = $this->container->getParameter('okvpn_migration.migrations_table');

        if ($event->isTableExist($table)) {
            $data = $event->getData(
                sprintf(
                    'select * from %s where id in (select max(id) from %s group by bundle)',
                    $table, $table
                )
            );
            foreach ($data as $val) {
                $event->setLoadedVersion($val['bundle'], $val['version']);
            }
        } else {
            $event->addMigration(new CreateMigrationTableMigration($this->container->getParameter('okvpn_migration.migrations_table')));
        }
    }
}
