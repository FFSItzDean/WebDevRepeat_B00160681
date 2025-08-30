<?php
// database connection settings
define('DB_HOST', 'localhost');  // mysql server location
define('DB_NAME', 'appointment_db');  // database name
define('DB_USER', 'root');  // database username
define('DB_PASS', '');  // database password

// folder paths for the application
define('BASE_PATH', dirname(__DIR__) . '/');  // root folder
define('APP_PATH', BASE_PATH . 'app/');  // app folder with models and controllers
define('VIEW_PATH', APP_PATH . 'views/');  // folder containing view files

// show all errors while developing
error_reporting(E_ALL);  // report every type of error
ini_set('display_errors', 1);  // display errors on screen
?>
