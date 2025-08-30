<?php
require_once 'app/models/Appointment.php';

// handles all appointment related actions
class AppointmentController {
    // database connection
    private $db;
    // appointment model instance
    private $appointment;

    // set up when controller starts
    public function __construct($db) {
        // start session if not running
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = $db;
        $this->appointment = new Appointment($this->db);
    }

    // show list of user's appointments
    public function index() {
        // check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $appointments = $this->appointment->getUserAppointments($_SESSION['user_id']);
        $pageTitle = "My Appointments";
        require_once 'app/views/appointments/index.php';
    }

    // make new appointment
    public function create() {
        // handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($this->appointment->create($_SESSION['user_id'], $title, $description, $date, $time)) {
                $_SESSION['message'] = "Appointment created successfully";
                $_SESSION['message_type'] = "success";
                header("Location: index.php?page=appointments");
                exit;
            } else {
                $_SESSION['message'] = "Failed to create appointment";
                $_SESSION['message_type'] = "danger";
            }
        }
        $pageTitle = "Create Appointment";
        require_once 'app/views/appointments/create.php';
    }

    // change existing appointment
    public function edit() {
        // get appointment id from url
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($this->appointment->update($id, $title, $description, $date, $time, $status)) {
                $_SESSION['message'] = "Appointment updated successfully";
                $_SESSION['message_type'] = "success";
                header("Location: index.php?page=appointments");
                exit;
            } else {
                $_SESSION['message'] = "Failed to update appointment";
                $_SESSION['message_type'] = "danger";
            }
        }

        $appointment = $this->appointment->getById($id);
        $pageTitle = "Edit Appointment";
        require_once 'app/views/appointments/edit.php';
    }

    // remove an appointment
    public function delete() {
        // get appointment id from url
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if ($this->appointment->delete($id)) {
            $_SESSION['message'] = "Appointment deleted successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to delete appointment";
            $_SESSION['message_type'] = "danger";
        }
        
        header("Location: index.php?page=appointments");
        exit;
    }

    // find appointments by search term
    public function search() {
        // clean up search text
        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $appointments = $this->appointment->search($_SESSION['user_id'], $search);
        $pageTitle = "Search Results";
        require_once 'app/views/appointments/search.php';
    }
}
?>
