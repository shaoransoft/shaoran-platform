<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfc1fee035d6ed162a80eef1bf131135f
{
    public static $prefixLengthsPsr4 = array (
        'e' => 
        array (
            'eftec\\bladeonehtml\\' => 19,
            'eftec\\bladeone\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'eftec\\bladeonehtml\\' => 
        array (
            0 => __DIR__ . '/..' . '/eftec/bladeonehtml/lib',
        ),
        'eftec\\bladeone\\' => 
        array (
            0 => __DIR__ . '/..' . '/eftec/bladeone/lib',
        ),
    );

    public static $prefixesPsr0 = array (
        'C' => 
        array (
            'ChrisKonnertz\\StringCalc' => 
            array (
                0 => __DIR__ . '/..' . '/chriskonnertz/string-calc/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfc1fee035d6ed162a80eef1bf131135f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfc1fee035d6ed162a80eef1bf131135f::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitfc1fee035d6ed162a80eef1bf131135f::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitfc1fee035d6ed162a80eef1bf131135f::$classMap;

        }, null, ClassLoader::class);
    }
}
