<?php

class user extends Controller{

    // public function __construct() {
    //     session_start();
    //     if (!isset($_SESSION['user_id'])) {
    //         // Redirect to login if not logged in
    //         header('Location: login');
    //         exit();
    //     }
    // }
    public function registeruser() {
        $this->view('user/registeruser');
    }
    public function viewpatient() {
        $this->view('user/viewpatient');
    }
    public function viewdoctor() {
        $this->view('user/viewdoctor');
    }
}