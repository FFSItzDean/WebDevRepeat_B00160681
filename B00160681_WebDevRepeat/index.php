<?php
// show all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// start user session
session_start();

// load required files
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/AppointmentController.php';

// connect to database
$database = new Database();
$db = $database->getConnection();

// get page from url
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'home';
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'index';

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'home';
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'index';

// pages that don't need login
$public_pages = ['home', 'about', 'login', 'register'];

// redirect to login if needed
if (!in_array($page, $public_pages) && !isset($_SESSION['user_id'])) {
    header('Location: /B00160681_WebDevRepeat/index.php?page=login');
    exit();
}

// send request to right controller
switch($page) {
    // appointment pages
        $controller = new AppointmentController($db);
        if(method_exists($controller, $action)) {
            $controller->$action();
        } else {
            $controller->index();
        }
        break;
    // user and auth pages
    case 'login':
    case 'register':
    case 'logout':
    case 'home':
    case 'about':
        $controller = new UserController($db);
        if(method_exists($controller, $page)) {
            $controller->$page();
        } else {
            header('Location: /B00160681_WebDevRepeat/index.php?page=home');
            exit();
        }
        break;
    default:
        header('Location: /B00160681_WebDevRepeat/index.php?page=home');
        exit();
}
?>
