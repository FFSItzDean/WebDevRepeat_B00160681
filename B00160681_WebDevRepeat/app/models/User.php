<?php
// handles user data and authentication
class User {
    // database connection
    private $conn;
    // name of users table
    private $table = 'users';

    // set up database when created
    public function __construct($db) {
        $this->conn = $db;
    }

    // create new user account
    public function register($username, $password, $email, $full_name) {
        $query = "INSERT INTO " . $this->table . " 
                (username, password, email, full_name) 
                VALUES (:username, :password, :email, :full_name)";

        $stmt = $this->conn->prepare($query);

        // Sanitize and hash
        $username = $username ?? '';
        $email = $email ?? '';
        $full_name = $full_name ?? '';
        $password = $password ?? '';
        
        $username = htmlspecialchars(strip_tags($username));
        $email = htmlspecialchars(strip_tags($email));
        $full_name = htmlspecialchars(strip_tags($full_name));
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Bind parameters
        error_log('Binding parameters...');
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":full_name", $full_name);
        error_log('Parameters bound successfully');

        try {
            if($stmt->execute()) {
                error_log('User::register - User registered successfully');
                return ['success' => true];
            }
            error_log('User::register - Registration failed');
            return ['success' => false, 'error' => 'Registration failed'];
        } catch (PDOException $e) {
            error_log('User::register - Database error: ' . $e->getMessage());
            if ($e->getCode() == 23000) { // Duplicate entry
                if (strpos($e->getMessage(), 'username')) {
                    return ['success' => false, 'error' => 'Username already exists'];
                } else if (strpos($e->getMessage(), 'email')) {
                    return ['success' => false, 'error' => 'Email already exists'];
                }
            }
            return ['success' => false, 'error' => 'Database error occurred'];
        }
    }

    // check login details and get user
    public function login($username, $password) {
        try {
            // Sanitize username the same way as registration
            $username = $username ?? '';
            $username = htmlspecialchars(strip_tags($username));
            error_log('Sanitized username: ' . $username);

            $query = "SELECT id, username, password FROM " . $this->table . " 
                    WHERE username = :username LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            error_log('Login query executed');
            error_log('Row count: ' . $stmt->rowCount());

            if($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                error_log('User::login - User found, verifying password');
                error_log('Stored password hash: ' . $row['password']);
                if(password_verify($password, $row['password'])) {
                    error_log('User::login - Password verified, login successful');
                    return ['success' => true, 'user_id' => $row['id']];
                }
                error_log('User::login - Invalid password');
                return ['success' => false, 'error' => 'Invalid password'];
            }
            error_log('User::login - User not found');
            return ['success' => false, 'error' => 'User not found'];
        } catch (PDOException $e) {
            error_log('User::login - Database error: ' . $e->getMessage());
            return ['success' => false, 'error' => 'Database error occurred'];
        }
    }

    // get user info by their id
    public function getUserById($id) {
        // find user by id
        $query = "SELECT id, username, email, full_name FROM " . $this->table . " 
                WHERE id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
