<?php
// handles database connection and setup
class Database {
    // database connection settings
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $conn;

    // connect to database or create if missing
    public function getConnection() {
        $this->conn = null;

        try {
            // connect to mysql server
            $pdo = new PDO(
                "mysql:host=" . $this->host,
                $this->username,
                $this->password
            );
            // show errors when they happen
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // see if our database exists
            $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . $this->db_name . "'");
            if (!$stmt->fetch()) {
                // create database and tables if missing
                $pdo->exec("CREATE DATABASE IF NOT EXISTS " . $this->db_name);
                $pdo->exec("USE " . $this->db_name);
                
                // Create users table
                $sql = "CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) UNIQUE NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    full_name VARCHAR(100) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                $pdo->exec($sql);

                // Create appointments table
                $sql = "CREATE TABLE IF NOT EXISTS appointments (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    title VARCHAR(100) NOT NULL,
                    description TEXT,
                    appointment_date DATE NOT NULL,
                    appointment_time TIME NOT NULL,
                    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )";
                $pdo->exec($sql);
                error_log('Database::getConnection - Tables created successfully');
            }
            
            // Now connect with database
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log('Database connection successful');
        } catch(PDOException $e) {
            error_log('Database connection error: ' . $e->getMessage());
            throw $e;
        }

        return $this->conn;
    }
}
?>
