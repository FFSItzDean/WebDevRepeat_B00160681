<?php
// handles all appointment related database operations
class Appointment {
    // database connection
    private $conn;
    // name of the appointments table
    private $table = 'appointments';

    // set up database connection when created
    public function __construct($db) {
        $this->conn = $db;
    }

    // saves a new appointment to database
    public function create($user_id, $title, $description, $date, $time) {
        // prepare insert query
        $query = "INSERT INTO " . $this->table . " 
                (user_id, title, description, appointment_date, appointment_time) 
                VALUES (:user_id, :title, :description, :date, :time)";

        $stmt = $this->conn->prepare($query);

        // clean up text to prevent html/script injection
        $title = htmlspecialchars(strip_tags($title));
        $description = htmlspecialchars(strip_tags($description));

        // Bind parameters
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":time", $time);

        return $stmt->execute();
    }

    // get all appointments for a specific user
    public function getUserAppointments($user_id) {
        // get appointments sorted by date and time
        $query = "SELECT * FROM " . $this->table . " 
                WHERE user_id = :user_id 
                ORDER BY appointment_date ASC, appointment_time ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // change an existing appointment
    public function update($id, $title, $description, $date, $time, $status) {
        // update query
        $query = "UPDATE " . $this->table . "
                SET title = :title, description = :description, 
                    appointment_date = :date, appointment_time = :time,
                    status = :status
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // clean up text
        $title = htmlspecialchars(strip_tags($title));
        $description = htmlspecialchars(strip_tags($description));
        $status = htmlspecialchars(strip_tags($status));

        // connect values to query
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":time", $time);
        $stmt->bindParam(":status", $status);

        return $stmt->execute();
    }

    // remove an appointment
    public function delete($id) {
        // delete query
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // find appointments by title or description
    public function search($user_id, $search_term) {
        // search in title and description
        $query = "SELECT * FROM " . $this->table . "
                WHERE user_id = :user_id 
                AND (title LIKE :search OR description LIKE :search)
                ORDER BY appointment_date ASC, appointment_time ASC";

        $stmt = $this->conn->prepare($query);
        
        $search_term = "%{$search_term}%";
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":search", $search_term);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get a single appointment by its id
    public function getById($id) {
        // find one appointment
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
