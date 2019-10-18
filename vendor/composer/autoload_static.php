<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd390322b992c68fd2c3d035a03d13b5b
{
    public static $files = array (
        '8ca8a91f0a826d6c6c8f274c90ca7d88' => __DIR__ . '/..' . '/wpmetabox/meta-box/meta-box.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPTRT\\AdminNotices\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPTRT\\AdminNotices\\' => 
        array (
            0 => __DIR__ . '/..' . '/wptrt/admin-notices/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd390322b992c68fd2c3d035a03d13b5b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd390322b992c68fd2c3d035a03d13b5b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
