<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 20/06/2015
 * Time: 19:24
 */

namespace Application\Model;


class DbAdapterConfig
{
    public static $dbAdapter = null;

    public static function getDbAdapter()
    {
        if (self::$dbAdapter == null) {
            self::$dbAdapter = array(
                'driver' => 'Pdo_mysql',
                'database' => 'dreamideas',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8'
            );
        }

        return self::$dbAdapter;
    }
}