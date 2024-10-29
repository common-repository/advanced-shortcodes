<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit78ee5df60b0b9f566815ce0f5972f8b0
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AdvancedShortcodes\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AdvancedShortcodes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'AdvancedShortcodes\\Admin\\Actions' => __DIR__ . '/../..' . '/includes/Admin/Actions.php',
        'AdvancedShortcodes\\Admin\\Admin' => __DIR__ . '/../..' . '/includes/Admin/Admin.php',
        'AdvancedShortcodes\\Admin\\ListTables\\ShortcodesListTable' => __DIR__ . '/../..' . '/includes/Admin/ListTables/ShortcodesListTable.php',
        'AdvancedShortcodes\\Controllers\\Shortcodes' => __DIR__ . '/../..' . '/includes/Controllers/Shortcodes.php',
        'AdvancedShortcodes\\Plugin' => __DIR__ . '/../..' . '/includes/Plugin.php',
        'AdvancedShortcodes\\PostTypes' => __DIR__ . '/../..' . '/includes/PostTypes.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit78ee5df60b0b9f566815ce0f5972f8b0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit78ee5df60b0b9f566815ce0f5972f8b0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit78ee5df60b0b9f566815ce0f5972f8b0::$classMap;

        }, null, ClassLoader::class);
    }
}
