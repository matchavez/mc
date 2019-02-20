<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf9be9936aae9e8f353ee7074d1eb9ad4
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Grav\\Plugin\\Database\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Grav\\Plugin\\Database\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf9be9936aae9e8f353ee7074d1eb9ad4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf9be9936aae9e8f353ee7074d1eb9ad4::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
