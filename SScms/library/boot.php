<?php

/**
 * Check php version
 */
if (version_compare(PHP_VERSION, '5.3') < 0) {
    die('We need PHP 5.3 or higher, you are running '.PHP_VERSION);
}

if (DEBUG) {
    error_reporting(-1);
} else {
    error_reporting(0);
}
define('CONFIG_PATH', ROOT.'config'.DS);

define('CORE_PATH', LIBRARY_PATH.'SScore'.DS);

require_once(CORE_PATH.'Autoloader.class.php');

spl_autoload_register("Autoloader::load");

Autoloader::directory(LIBRARY_PATH);

set_exception_handler(array('SScore\\Error', 'exception'));
set_error_handler(array('SScore\\Error', 'native'));
session_register_shutdown(array('SScore\\Error', 'shutdown'));
