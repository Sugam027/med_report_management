<?php

class Controller {

    // Load models
    public function model($model) {
        // Require the model file
        require_once '../app/models/' . $model . '.php';
        // Instantiate the model
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        require_once '../app/views/' . $view . '.php';
    }
}
