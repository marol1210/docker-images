<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit343646cbbab149bbcf2cf047cf85f8b0
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Marol\\AdminBase\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Marol\\AdminBase\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit343646cbbab149bbcf2cf047cf85f8b0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit343646cbbab149bbcf2cf047cf85f8b0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit343646cbbab149bbcf2cf047cf85f8b0::$classMap;

        }, null, ClassLoader::class);
    }
}
