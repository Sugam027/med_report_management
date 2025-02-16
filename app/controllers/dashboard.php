<?php

class dashboard extends BaseController{

    private $userModel;
    private $appointmentModel;
    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('Users');
        $this->appointmentModel = $this->model('Appointments');

        
    }
    public function index() {
        $this->auth_route->checkPermission([1,2,3]);
        $totalUsers = $this->userModel->total_users();
        $totalDoctors = $this->userModel->total_doctors();
        $totalPatients = $this->userModel->total_patients();
        $totalAppointments = $this->appointmentModel->total_appointments();
        $totalVisited = $this->appointmentModel->totalPreviousAppointments();

        // print_r($totalUsers);
        $data = [
            'totalUsers' => $totalUsers,
            'totalDoctors' => $totalDoctors,
            'totalPatients' => $totalPatients,
            'totalAppointments' => $totalAppointments,
            'totalVisited' => $totalVisited,
        ];

        $this->view('dashboard/index', $data);
    }
    public function changepassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the appointment ID and status from the form submission
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Collect data from the form
            $userId = $_POST['user_id'];
            $password = trim($_POST['password']);
            $cpassword = trim($_POST['cpassword']);

            if ($password !== $cpassword) {
                $this->auth_route->setSessionMessage(false, 'Passwords do not match');
            } else {
                unset($_POST['cpassword']);
                $result = $this->userModel->changePassword($userId, password_hash($password,PASSWORD_DEFAULT));
                if ($result) {
                    $this->auth_route->setSessionMessage(true, 'Password Changed Successfully');
                    $this->auth_route->redirect('/dashboard');
                } else {
                    $this->auth_route->setSessionMessage(false, 'Password Change Failed');
                }
            }
        }
        $this->view('dashboard/changepassword');
    }
}