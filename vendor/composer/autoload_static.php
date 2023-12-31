<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit458308443ac0827bed72ea6ff368b316
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpMimeMailParser\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpMimeMailParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-mime-mail-parser/php-mime-mail-parser/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit458308443ac0827bed72ea6ff368b316::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit458308443ac0827bed72ea6ff368b316::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit458308443ac0827bed72ea6ff368b316::$classMap;

        }, null, ClassLoader::class);
    }
}
