<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}
if (!defined('APP_DIR')) {
    define('APP_DIR', 'src');
}
if (!defined('CONFIG')) {
    define('CONFIG', ROOT.'/config/');
}

$vendorPath = ROOT.'/vendor/friendsofcake2/cakephp/lib';
$dispatcher = 'Cake/Console/ShellDispatcher.php';
if (!defined('CAKE_CORE_INCLUDE_PATH') && file_exists($vendorPath.'/'.$dispatcher)) {
    define('CAKE_CORE_INCLUDE_PATH', $vendorPath);
}

if (!defined('WEBROOT_DIR')) {
    define('WEBROOT_DIR', basename(__DIR__));
}
if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', __DIR__.'/');
}
if (!defined('VENDORS')) {
    define('VENDORS', ROOT.'/vendor/');
}
if (!defined('TESTS')) {
    define('TESTS', ROOT.'/tests/');
}
if (!defined('TMP')) {
    define('TMP', ROOT.'/tmp/');
}
if (!defined('LOGS')) {
    define('LOGS', ROOT.'/logs/');
}

// For the built-in server
if (PHP_SAPI === 'cli-server') {
    if ('/' !== $_SERVER['REQUEST_URI'] && file_exists(WWW_ROOT.$_SERVER['PHP_SELF'])) {
        return false;
    }
    $_SERVER['PHP_SELF'] = '/'.basename(__FILE__);
}
$_SERVER['PHP_SELF'] = '/'.basename(__FILE__);

if (!include CAKE_CORE_INCLUDE_PATH.'/Cake/bootstrap.php') {
    trigger_error('CakePHP core could not be found. Check the value of CAKE_CORE_INCLUDE_PATH in APP/webroot/index.php. It should point to the directory containing your /cake core directory and your /vendors root directory.', E_USER_ERROR);
}

App::uses('Dispatcher', 'Routing');

$Dispatcher = new Dispatcher();
$Dispatcher->dispatch(
    new CakeRequest(),
    new CakeResponse()
);
