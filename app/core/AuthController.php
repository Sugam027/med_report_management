<?php

class AuthController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        if ($_SERVER['REQUEST_URI'] != '/auth/logout' && $this->auth_route->checkIsLoggedIn()) {
            $this->auth_route->redirect();
        }
    }
}