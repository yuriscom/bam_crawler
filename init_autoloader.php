<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/**
 * This autoloading setup is really more complicated than it needs to be for most
 * applications. The added complexity is simply to reduce the time it takes for
 * new developers to be productive with a fresh skeleton. It allows autoloading
 * to be correctly configured, regardless of the installation method and keeps
 * the use of composer completely optional. This setup should work fine for
 * most users, however, feel free to configure autoloading however you'd like.
 */
set_include_path('.'
        . PATH_SEPARATOR . __DIR__ . '/lib'
        . PATH_SEPARATOR . get_include_path());

// Composer autoloading
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

if (isset($loader)) {
    $loader->setUseIncludePath(true);
}
