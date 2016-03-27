<?php



//exit();

define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');

define('LIBRARY_PATH', ROOT.DS.'library'.DS);

define('DEBUG', true);
include(LIBRARY_PATH.'boot.php');

SScore\Application::start();
