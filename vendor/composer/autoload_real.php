<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitf01ca2e7ccfd85272670bf19ebc4f1fb
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitf01ca2e7ccfd85272670bf19ebc4f1fb', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitf01ca2e7ccfd85272670bf19ebc4f1fb', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitf01ca2e7ccfd85272670bf19ebc4f1fb::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
