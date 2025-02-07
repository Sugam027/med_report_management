<?php

class doctor extends BaseController{

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('Users');
    }
    public function index() {
        $this->auth_route->checkPermission([1,2,3]);
        // $doctors = $this->userModel->getDoctors();  // Get all doctors
        $doctors = $this->userModel->getDoctorDetails();  // Get all doctors
        $data = [
            'doctors' => $doctors,
        ];

        $this->view('doctor/index', $data);
    }
}