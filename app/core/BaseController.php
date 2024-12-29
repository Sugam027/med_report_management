<?php

class BaseController extends Controller{

    private $userModel;

    public function __construct() {
        // Load the Users model
        parent::__construct();
        $this->userModel = $this->model('Users');

        // Load user data for all pages if the user is logged in
        if (isset($_SESSION['user_id'])) {
            $userData = $this->userModel->getLoginUser($_SESSION['user_id']);
            // Pass user data to views automatically
            $this->setViewData('userData', $userData);
        }
    }
}
