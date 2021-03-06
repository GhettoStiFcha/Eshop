<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5c8b165362c8a1a6135f7a1801d01183
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Database\\' => 9,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Database\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Database',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Controllers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5c8b165362c8a1a6135f7a1801d01183::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5c8b165362c8a1a6135f7a1801d01183::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
