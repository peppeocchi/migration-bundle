<?php

namespace Okvpn\Bundle\MigrationBundle\Tests\Unit\Migration;

use Doctrine\DBAL\Schema\Schema;
use Okvpn\Bundle\MigrationBundle\Migration\CreateMigrationTableMigration;
use Okvpn\Bundle\MigrationBundle\Migration\QueryBag;
use Okvpn\Bundle\MigrationBundle\Migration\MigrationsConfig;

class CreateMigrationTableMigrationTest extends \PHPUnit_Framework_TestCase
{
    public function testUp()
    {
        $schema          = new Schema();
        $queryBag        = new QueryBag();
        $createMigration = new CreateMigrationTableMigration();
        $createMigration->up($schema, $queryBag);

        $this->assertEmpty($queryBag->getPreQueries());
        $this->assertEmpty($queryBag->getPostQueries());

        $table = $schema->getTable(MigrationsConfig::get('table'));
        $this->assertTrue($table->hasColumn('id'));
        $this->assertTrue($table->hasColumn('bundle'));
        $this->assertTrue($table->hasColumn('version'));
        $this->assertTrue($table->hasColumn('loaded_at'));
    }
}
