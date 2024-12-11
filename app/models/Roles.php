<?php

class Roles extends Controller{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all roles
    public function getRoles() {
        $this->db->query("SELECT * FROM roles WHERE title != 'admin' ORDER BY title DESC");
        return $this->db->resultSet();
    }

}
