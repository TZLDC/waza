<?php

namespace Base\Config\Pro;

class Db extends \Base\Config\Db
{
    const master = [
        'database' => 'waza',
        'host' => '10.33.0.51',
        'username' => 'neomars',
        'password' => 'jCGRImKX',
        'charset' => 'utf8',
        'option' => [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            //\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ],
    ];
}
