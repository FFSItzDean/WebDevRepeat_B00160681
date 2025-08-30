<?php
require_once dirname(__DIR__) . '/models/User.php';

// handles user login and registration
class UserController {
    // database connection
    private $db;
    // user model instance
    private $user;

    // set up when controller starts
    public function __construct() {
        // start session if not running
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // connect to database
        $database = new Database();
        $db = $database->getConnection();
        $this->db = $db;
        $this->user = new User($this->db);
    }

    public function index() {
        $pageTitle = "Home";
        require_once dirname(__DIR__) . '/views/home/index.php';
    }

    public function about() {
        $pageTitle = "About";
        require_once dirname(__DIR__) . '/views/home/about.php';
    }

    // handle user login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean up login data
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW) ?? '';

            error_log('Attempting login with username: ' . $username);
            $result = $this->user->login($username, $password);
            error_log('Login result: ' . print_r($result, true));
            
            if($result['success']) {
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['message'] = "Login successful";
                $_SESSION['message_type'] = "success";
                header("Location: /B00160681_WebDevRepeat/index.php?page=home");
                exit;
            } else {
                $_SESSION['message'] = $result['error'];
                $_SESSION['message_type'] = "danger";
            }
        }
        $pageTitle = "Login";
        require_once dirname(__DIR__) . '/views/auth/login.php';
    }

    // handle new user signup
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean up registration data
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW) ?? '';
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            error_log('Attempting to register user: ' . $username);
            error_log('Attempting to register with data: ' . json_encode([
                'username' => $username,
                'email' => $email,
                'full_name' => $full_name
            ]));
            $result = $this->user->register($username, $password, $email, $full_name);
            if ($result['success']) {
                error_log('User registered successfully');
                $_SESSION['message'] = "Registration successful. Please login.";
                $_SESSION['message_type'] = "success";
                header("Location: /B00160681_WebDevRepeat/index.php?page=login");
                exit;
            } else {
                $_SESSION['message'] = $result['error'];
                $_SESSION['message_type'] = "danger";
            }
        }
        $pageTitle = "Register";
        require_once dirname(__DIR__) . '/views/auth/register.php';
    }

    public function home() {
        $pageTitle = "Home";
        require_once dirname(__DIR__) . '/views/home/index.php';
    }

    // end user session
    public function logout() {
        session_destroy();
        header("Location: /B00160681_WebDevRepeat/index.php?page=login");
        exit;
    }
}
?>
