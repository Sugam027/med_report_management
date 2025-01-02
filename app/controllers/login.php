<?php


class login extends BaseController {
    private $setup;
    private $userModel;

    public function __construct() {
        parent::__construct();
        // Instantiate the DatabaseQuery class to run table creation
        $this->setup = new Departments();
        $this->setup->insertDepartment();  // Automatically create the users table when the login page loads
        
        $this->userModel = $this->model('Users');
    }

    public function index() {
        $data = [
            'username' => '',
            'password' => '',
            'username_error' => '',
            'password_error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Collect data from the form
            // $username = trim($_POST['username']);
            // $password = trim($_POST['password']);

             // Collect data from the form
            $data['username'] = trim($_POST['username']);
            $data['password'] = trim($_POST['password']);

            // Validation
            if (empty($data['username'])) {
                $data['username_error'] = 'Username is required.';
            }

            if (empty($data['password'])) {
                $data['password_error'] = 'Password is required.';
            }

            // Check if user exists
            // If no errors, proceed to authenticate
            if (empty($data['username_error']) && empty($data['password_error'])) {
                $user = $this->userModel->findUserByUsername($data['username']);
                if ($user && password_verify($data['password'], $user['password'])) {
                    // Password is correct, start the session
                    Session::start();
                    Session::set('user_id', $user['user_id']);
                    Session::set('role_id', $user['role_id']);
                    $this->auth_route->setSessionMessage(true, 'Login successful');
                    $this->auth_route->redirect('dashboard');
                    exit;
                } else {
                    // $this->auth_route->redirect();
                    $data['password_error'] = 'Invalid username or password.';
                }
            }
        }
        // Load the login view with errors
        $this->view('login/index', $data);
    }

    // Handle login form submission
    // public function authenticate() {

    //     $data = [
    //         'username' => '',
    //         'password' => '',
    //         'username_error' => '',
    //         'password_error' => ''
    //     ];

    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         // Sanitize POST data
    //         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //         // Collect data from the form
    //         // $username = trim($_POST['username']);
    //         // $password = trim($_POST['password']);

    //          // Collect data from the form
    //         $data['username'] = trim($_POST['username']);
    //         $data['password'] = trim($_POST['password']);

    //         // Validation
    //         if (empty($data['username'])) {
    //             $data['username_error'] = 'Username is required.';
    //         }

    //         if (empty($data['password'])) {
    //             $data['password_error'] = 'Password is required.';
    //         }

    //         // Check if user exists
    //         // If no errors, proceed to authenticate
    //         if (empty($data['username_error']) && empty($data['password_error'])) {
    //             $user = $this->userModel->findUserByUsername($data['username']);
    //             if ($user && password_verify($data['password'], $user['password'])) {
    //                 // Password is correct, start the session
    //                 Session::start();
    //                 Session::set('user_id', $user['user_id']);
    //                 Session::set('role_id', $user['role_id']);
    //                 $this->auth_route->setSessionMessage(true, 'Login successful');
    //                 $this->auth_route->redirect('dashboard');
    //                 exit;
    //             } else {
    //                 $this->auth_route->redirect();
    //                 $data['username_error'] = 'Invalid username or password.';
    //             }
    //         }
    //     }
    //     // Load the login view with errors
    //     $this->view('login/index', $data);
    // }

    // Handle logout
    public function logout() {
        session_destroy();
        $this->auth_route->redirect();
    }

}