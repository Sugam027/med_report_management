<?php

class doctor extends BaseController{

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('Users');
    }
    public function index() {
        $doctors = $this->userModel->getDoctors();  // Get all doctors
        $data = [
            'doctors' => $doctors,
        ];

        $this->view('doctor/index', $data);
    }
}