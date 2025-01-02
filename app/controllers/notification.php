<?php

class notification extends BaseController{
    private $notificationModel;
    public function __construct() {
        parent::__construct();
        $this->notificationModel = $this->model('Notifications');

        
    }
    public function index() {
        $this->auth_route->checkPermission([2,3]);
        $userId = $_SESSION['user_id'];
        $notifications= $this->notificationModel->getNotifications($userId);

        $data = [
            'notifications' => $notifications
        ];

        $this->view('notification/index', $data);
    }
}