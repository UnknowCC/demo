<?php



//exit();


define('DS', DIRECTORY_SEPARATOR);
define('ROOT', ltrim(dirname(__FILE__), '/').DS);
define('EXT', '.php');

define('LIBRARY_PATH', ROOT.DS.'library'.DS);

define('DEBUG', true);
include(LIBRARY_PATH.'boot.php');

SScore\Application::start();
