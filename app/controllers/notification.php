<?php

class notification extends BaseController{
    private $notificationModel;
    public function __construct() {
        parent::__construct();
        $this->notificationModel = $this->model('Notifications');

        
    }
    public function index() {
        $userId = $_SESSION['user_id'];
        $notifications= $this->notificationModel->getNotifications($userId);

        $data = [
            'notifications' => $notifications
        ];
        print_r($data);

        $this->view('notification/index', $data);
    }
}