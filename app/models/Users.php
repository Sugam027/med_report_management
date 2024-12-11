<?php
require_once __DIR__ . '/../core/Sql.php';
class Users{
    private $db;
    public function __construct() {
        $this->db = new Sql();
    }
    

    // last userId
    public function lastInsertedId(){
        $this->db->query("SELECT user_id FROM users");

    }

    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        return $this->db->single();  // Return single user record

        if ($row) {
            // Verify password
            if (password_verify($password, $row->password)) {
                return $row;  // Return the user data
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Insert user data into all three tables
    public function register($userData, $userDetailsData, $doctorDetailsData = null) {
        try {
            // Start transaction
            $this->db->beginTransaction();
            // Insert into users table
            $userId = $this->db->insertData('users', $userData); // Store the ID from the insert
    
            // Insert into user_details table
            $userDetailsData['user_id'] = $userId;
            $this->db->insertData('user_details', $userDetailsData);
    
            // If doctor details are provided, insert into doctor_details table
            if ($doctorDetailsData) {
                $doctorDetailsData['user_id'] = $userId;
                $this->db->insertData('doctor_details', $doctorDetailsData);
            }
    
            // Commit transaction
            $this->db->commit();
            return $userId;
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            $this->db->rollBack();
            error_log("Registration failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }

    // Get all doctors
    public function getDoctors()
    {
        return $this->db->getData('users', ['role_id' => 2]); // Assuming role_id 2 is for doctors
    }

    // Get all patients
    public function getPatients()
    {
        return $this->db->getData('users', ['role_id' => 3]); // Assuming role_id 1 is for patients
    }
    

    

}