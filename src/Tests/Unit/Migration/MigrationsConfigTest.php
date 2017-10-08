<?php

namespace Okvpn\Bundle\MigrationBundle\Tests\Unit\Migration;

use Okvpn\Bundle\MigrationBundle\Migration\MigrationsConfig;
use Symfony\Component\Yaml\Yaml;

class MigrationsConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfigByKey()
    {
        // These are the default values
        $this->assertEquals(MigrationsConfig::get('table'), 'okvpn_migrations');
        $this->assertEquals(MigrationsConfig::get('path'), 'Migrations/Schema');
    }

    public function testReturnsDefaultValueIfConfigKeyDoesNotExists()
    {
        $value = MigrationsConfig::get('invalid', 'myDefaultValue');

        $this->assertEquals($value, 'myDefaultValue');
    }

    public function testLoadConfigFromCustomPath()
    {
        $customConfigPath = tempnam(sys_get_temp_dir(), 'okvpn_config');

        $yaml = Yaml::dump([
            'okvpn_migration' => [
                'migrations_table' => 'my_migrations',
                'migrations_path' => 'My/Custom/Migrations/Schema',
            ]
        ]);

        file_put_contents($customConfigPath, $yaml);

        MigrationsConfig::load($customConfigPath);

        $this->assertEquals(MigrationsConfig::get('table'), 'my_migrations');
        $this->assertEquals(MigrationsConfig::get('path'), 'My/Custom/Migrations/Schema');
    }
}
