<?php

namespace App\Config;

class_alias('\Base\Config\\' . ucfirst(APP_ENV) . '\Code', "BaseCodeConfig");

class Code extends \BaseCodeConfig
{
    public $menu = [
        'demo' => [
            'name' => '问答管理',
            'sub' => [
                'index' => ['name' => '问答列表', 'uri' => '/demo/index'],
                'input' => ['name' => '添加问答', 'uri' => '/demo/input'],
                'image_index' => ['name' => '图片列表', 'uri' => '/demo/image_index'],
                'image_input' => ['name' => '图片添加', 'uri' => '/demo/image_input'],
            ]
        ],
    ];
    
    public $question = [
        'type' => [
            1 => ['name' => '单选', 'value' => 1],
            2 => ['name' => '多选', 'value' => 2],
            3 => ['name' => '判断', 'value' => 3],
        ],
    ];
    
    public $order = [
        'demo' => [
            'a' => [
                'field' => 'a.qid',
                'type' => 'asc',
            ],
            'b' => [
                'field' => 'a.question',
                'type' => 'asc',
            ],
        ],
        
        'user' => [
            'a' => [
                'field' => 'email',
                'type' => 'desc',
            ],
        ],
    ];
    
    public $paging = [
        'default' => [
            10 => '10条',
            20 => '20条',
            50 => '50条',
            0 => '所有',
        ],
        
        'demo' => [
            5 => '5条',
            20 => '20条',
            50 => '50条',
            0 => '所有',
        ],
    ];
    
    public $uploadDir = [
        'demo' => WEB_PATH . '/upload/demo/',
    ];
}
