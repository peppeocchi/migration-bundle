<?php

namespace Okvpn\Bundle\MigrationBundle\Tests\Unit\Migration;

use Doctrine\DBAL\Schema\Schema;
use Okvpn\Bundle\MigrationBundle\Migration\CreateMigrationTableMigration;
use Okvpn\Bundle\MigrationBundle\Migration\QueryBag;

class CreateMigrationTableMigrationTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $container;

    protected function setUp()
    {
        $this->container = $this->getMockForAbstractClass(
            'Symfony\Component\DependencyInjection\ContainerInterface'
        );
    }

    public function testUp()
    {
        $schema          = new Schema();
        $queryBag        = new QueryBag();
        $createMigration = new CreateMigrationTableMigration($this->container->getParameter('okvpn_migration.migrations_table'));
        $createMigration->up($schema, $queryBag);

        $this->assertEmpty($queryBag->getPreQueries());
        $this->assertEmpty($queryBag->getPostQueries());

        $table = $schema->getTable($this->container->getParameter('okvpn_migration.migrations_table'));
        $this->assertTrue($table->hasColumn('id'));
        $this->assertTrue($table->hasColumn('bundle'));
        $this->assertTrue($table->hasColumn('version'));
        $this->assertTrue($table->hasColumn('loaded_at'));
    }
}
