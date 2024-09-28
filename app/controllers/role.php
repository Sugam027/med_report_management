<?php

class Role {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all roles
    public function getRoles() {
        $this->db->query("SELECT * FROM roles");
        return $this->db->resultSet();
    }
}
