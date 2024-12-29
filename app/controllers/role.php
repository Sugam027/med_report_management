<?php

class Role extends BaseController{
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = new Database();
    }


}
