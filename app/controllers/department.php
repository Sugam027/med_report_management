<?php

class department extends BaseController{

    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->view('department/index');
    }

   

}