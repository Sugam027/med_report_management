<?php

class appointment extends Controller{
    private $userModel;


    public function __construct() {
        // Load the User and Role models
        $this->userModel = $this->model('Users');
    }
    public function index() {


        $doctors = $this->userModel->getDoctors();  // Get all doctors
        $data = [
            'doctors' => $doctors,
            
        ];
        $this->view('appointment/index', $data);
    }
}