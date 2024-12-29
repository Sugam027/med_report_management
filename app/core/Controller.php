<?php

class Controller {

    protected $base_url;
    protected $auth_route;
    protected $viewData = [];

    public function __construct()
    {
        $this->base_url = $GLOBALS['base_url'];
        $this->auth_route = new AuthRoute();
    }
    // Load models
    public function model($model) {
        // Require the model file
        require_once '../app/models/' . $model . '.php';
        // Instantiate the model
        return new $model();
    }

     // Set data for the view
     public function setViewData($key, $value) {
        $this->viewData[$key] = $value;
    }

    // Load view with data
    public function view($view, $data = []) {
        // Merge the class-level data with the data passed to the view
        $data = array_merge($this->viewData, $data);
        extract($data);  // Extract the array data as individual variables
        require_once '../app/views/' . $view . '.php';
    }
}
