<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit19e2e58a89ba8522eeadcef0e65b0f05
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Leafo\\ScssPhp\\' => 14,
        ),
        'G' => 
        array (
            'Gantry\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Leafo\\ScssPhp\\' => 
        array (
            0 => __DIR__ . '/..' . '/leafo/scssphp/src',
        ),
        'Gantry\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/Gantry',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit19e2e58a89ba8522eeadcef0e65b0f05::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit19e2e58a89ba8522eeadcef0e65b0f05::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
