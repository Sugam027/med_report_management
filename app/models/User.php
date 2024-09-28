<?php

class User {
    private $db;

    public function __construct() {
        // Initialize database connection
        $this->db = new Database();
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

}