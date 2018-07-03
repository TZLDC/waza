<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit78bdc55d6788c251145077d3a48a01d4
{
    public static $files = array (
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '2cffec82183ee1cea088009cef9a6fc3' => __DIR__ . '/..' . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
        'f084d01b0a599f67676cffef638aa95b' => __DIR__ . '/..' . '/smarty/smarty/libs/bootstrap.php',
        '8a6b4e3398f4dd0d1eeadbbe87812dcf' => __DIR__ . '/..' . '/windward/framework/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Windward\\Tests\\' => 15,
            'Windward\\' => 9,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
        ),
        'I' => 
        array (
            'Intervention\\Image\\' => 19,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'Gregwar\\Captcha\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Windward\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/windward/framework/tests/src',
        ),
        'Windward\\' => 
        array (
            0 => __DIR__ . '/..' . '/windward/framework/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Intervention\\Image\\' => 
        array (
            0 => __DIR__ . '/..' . '/intervention/image/src/Intervention/Image',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'Gregwar\\Captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/gregwar/captcha',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pagerfanta\\' => 
            array (
                0 => __DIR__ . '/..' . '/pagerfanta/pagerfanta/src',
            ),
        ),
        'H' => 
        array (
            'HTMLPurifier' => 
            array (
                0 => __DIR__ . '/..' . '/ezyang/htmlpurifier/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit78bdc55d6788c251145077d3a48a01d4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit78bdc55d6788c251145077d3a48a01d4::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit78bdc55d6788c251145077d3a48a01d4::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}