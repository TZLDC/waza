<?php

namespace Base\Config;

class Db extends \Windward\Config\Config
{

    const master = [
        'database' => 'waza',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'option' => [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ],
    ];
    
    const slave = [];

}
