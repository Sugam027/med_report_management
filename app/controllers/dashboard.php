<?php

class dashboard extends Controller{

    // public function __construct() {
    //     session_start();
    //     if (!isset($_SESSION['user_id'])) {
    //         // Redirect to login if not logged in
    //         header('Location: login');
    //         exit();
    //     }
    // }
    public function index() {
        $this->view('dashboard/index');
    }
}