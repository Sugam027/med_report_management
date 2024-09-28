<?php

require_once __DIR__ . '/../models/databasequery.php';


class login extends Controller {
    private $setup;
    private $userModel;

    public function __construct() {
        // Instantiate the DatabaseQuery class to run table creation
        $this->setup = new DatabaseQuery();
        $this->setup->createUsersTable();  // Automatically create the users table when the login page loads
        $this->userModel = $this->model('User');
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
            if ($user && password_verify($password, $user->password)) {
                // Password is correct, start the session
                Session::start();
                Session::set('user_id', $user->userId);
                Session::set('username', $user->username);
                Session::set('role', $user->role);

                // Redirect to a protected page (dashboard)
                header('Location: ' . BASE_URL . 'dashboard');
                // header('Location: dashboard');
                exit;
            } else {
                // Display an error message (user not found or password incorrect)
                echo "Invalid username or password!";
            }
        }
    }

    // Handle logout
    public function logout() {
        Session::destroy();
        header('Location: /login');
        exit;
    }

}