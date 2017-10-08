<?php

namespace Okvpn\Bundle\MigrationBundle\EventListener;

use Okvpn\Bundle\MigrationBundle\Event\PreMigrationEvent;
use Okvpn\Bundle\MigrationBundle\Migration\CreateMigrationTableMigration;
use Okvpn\Bundle\MigrationBundle\Migration\MigrationsConfig;

class PreUpMigrationListener
{
    /**
     * @param PreMigrationEvent $event
     */
    public function onPreUp(PreMigrationEvent $event)
    {
        $table = MigrationsConfig::get('table');

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
            $event->addMigration(new CreateMigrationTableMigration());
        }
    }
}
