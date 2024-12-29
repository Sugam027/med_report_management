<?php
// require_once __DIR__ . '/../core/Sql.php';
class Notifications{
    private $db;
    public function __construct() {
        $this->db = new Sql();
        $this->auth_route = new AuthRoute();
    }

    public function getNotifications($userId) {
        $conditions = ['n.user_id' => $userId];
        $fields = 'n.*, u.name';
        $joins = ['users u' => 'n.user_id =  u.user_id'];
        $orderBy = 'created_at DESC';
        return $this->db->getData('notifications n', $conditions, $fields, $joins, '', $orderBy  );
    }

}