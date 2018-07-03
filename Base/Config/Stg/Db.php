<?php

namespace Base\Config\Stg;

class Db extends \Base\Config\Db
{
    const master = [
        'database' => 'waza',
        'host' => '127.0.0.1',
        'username' => 'neomars',
        'password' => 'jCGRImKX',
        'charset' => 'utf8',
        'option' => [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            //\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ],
    ];
}
