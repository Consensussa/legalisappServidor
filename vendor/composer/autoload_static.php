<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7adbdcabb021f5359dacc947efed56d3
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'ZipMerge\\' => 9,
        ),
        'S' => 
        array (
            'Slim\\Views\\' => 11,
            'Slim\\' => 5,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'PHPZip\\Zip\\' => 11,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'I' => 
        array (
            'Interop\\Container\\' => 18,
        ),
        'F' => 
        array (
            'FastRoute\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ZipMerge\\' => 
        array (
            0 => __DIR__ . '/..' . '/grandt/phpzipmerge/src/ZipMerge',
        ),
        'Slim\\Views\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/php-view/src',
        ),
        'Slim\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/Slim',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'PHPZip\\Zip\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpzip/phpzip/src/Zip',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Interop\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 
            array (
                0 => __DIR__ . '/..' . '/psr/log',
            ),
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static $classMap = array (
        'RelativePath' => __DIR__ . '/..' . '/grandt/relativepath/RelativePath.php',
        'com\\grandt\\BinString' => __DIR__ . '/..' . '/grandt/binstring/BinString.php',
        'com\\grandt\\BinStringStatic' => __DIR__ . '/..' . '/grandt/binstring/BinStringStatic.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7adbdcabb021f5359dacc947efed56d3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7adbdcabb021f5359dacc947efed56d3::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit7adbdcabb021f5359dacc947efed56d3::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit7adbdcabb021f5359dacc947efed56d3::$classMap;

        }, null, ClassLoader::class);
    }
}