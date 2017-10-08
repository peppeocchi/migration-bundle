<?php

namespace Okvpn\Bundle\MigrationBundle\Migration;

use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

class MigrationsConfig
{
    /**
     * @var array
     */
    protected static $config;

    /**
     * @var string
     */
    protected static $path = __DIR__.'/../../../config.yml';

    protected function __construct()
    {
        self::load(self::$path);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * Load config file from path
     *
     * @param  string  $path
     */
    public static function load($path)
    {
        if (file_exists($path)) {
            self::$path = $path;

            try {
                $config = Yaml::parse(file_get_contents(self::$path));
            } catch (\ParseException $e) {
                throw new InvalidArgumentException("Unable to parse the YAML configuration: %s", $e->getMessage());
            }
        } else {
            $config = [];
        }

        self::$config['table'] = isset($config['okvpn_migration']['migrations_table']) ?
            $config['okvpn_migration']['migrations_table'] :
            'okvpn_migrations';

        self::$config['path'] = isset($config['okvpn_migration']['migrations_path']) ?
            $config['okvpn_migration']['migrations_path'] :
            'Migrations/Schema';
    }

    /**
     * Get config by key
     *
     * @param  string  $key
     * @param  string  $default
     * @return string
     */
    public static function get($key, $default = '')
    {
        if (! self::$config) {
            new static();
        }

        return isset(self::$config[$key]) ? self::$config[$key] : $default;
    }
}
