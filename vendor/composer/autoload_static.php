<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc78095b94a70a7eac551eae0b934bc03
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Dotenv\\' => 25,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dotenv',
        ),
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitc78095b94a70a7eac551eae0b934bc03::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc78095b94a70a7eac551eae0b934bc03::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc78095b94a70a7eac551eae0b934bc03::$classMap;

        }, null, ClassLoader::class);
    }
}
