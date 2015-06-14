<?php


namespace Wibbo\Db;


class DbConfiguration
{

    static function generate($databaseUrl)
    {
        if (empty($databaseUrl)) {
            return array(
              'driver' => 'pdo_pgsql',
              'host' => 'localhost',
              'dbname' => 'wibbo',
              'user' => 'local',
              'password' => 'local',
              'charset' => 'utf8',
            );
        }

        $databaseUrl = parse_url($databaseUrl);

        return array(
          'driver' => 'pdo_pgsql',
          'host' => $databaseUrl['host'],
          'user' => $databaseUrl['user'],
          'dbname' => substr($databaseUrl['path'], 1),
          'password' => $databaseUrl['pass'],
          'charset' => 'utf8'
        );
    }

}