<?php

class Role extends Controller{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }


}
