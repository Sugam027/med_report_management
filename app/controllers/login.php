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
        $this->view('login/index');
    }

    // Handle login form submission
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Collect data from the form
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Check if user exists
            $user = $this->userModel->findUserByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                // Password is correct, start the session
                Session::start();
                Session::set('user_id', $user['user_id']);
                Session::set('role_id', $user['role_id']);

                $this->auth_route->setSessionMessage(true, 'Login successful');

                $this->auth_route->redirect('dashboard');
                // Redirect to a protected page (dashboard)
                // header('Location: ' . BASE_URL . 'dashboard');
                // header('Location: dashboard');
                exit;
            } else {
                // Display an error message (user not found or password incorrect)
                echo "Invalid username or password!";
                $this->auth_route->setSessionMessage(false, 'Invalid username or password');
                $this->auth_route->redirect('');
            }
        }
    }

    // Handle logout
    public function logout() {
        session_destroy();
        $this->auth_route->redirect();
    }

}