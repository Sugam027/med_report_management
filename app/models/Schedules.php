<?php
require_once __DIR__ . '/../core/Sql.php';
class Schedules{
    private $db;
    public function __construct() {
        $this->db = new Sql();
        $this->auth_route = new AuthRoute();
    }
    

    // last userId
    public function lastInsertedId(){
        $this->db->query("SELECT user_id FROM users");

    }

    // Insert user data into all three tables
    public function updateSchedule($scheduleData) {
        try {
            // Insert into users table
            $this->db->beginTransaction();
            // Insert into users table
            $doctorId = $this->db->insertData('doctor_schedule', $scheduleData); 

            if ($doctorId) {
                // Create notification for doctor
                $doctorNotification = [
                    'user_id' => $scheduleData['user_id'],
                    'message' => 'You have a new scheduled from tomorrow.',
                ];
                $this->db->insertData('notifications', $doctorNotification);
    
                // Commit transaction
                $this->db->commit();
                return true;
            } else {
                // Rollback transaction on failure
                $this->db->rollback();
                return false;
            }
            
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            error_log("Scheduling failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }
    
    public function getScheduleWithShifts($todayDay) {
        $table = 'doctor_schedule s';
        $conditions = []; // No specific conditions for the table
        $fields = 's.doctor_name, sh.title AS shift, sh.start_time, sh.end_time, 
                   CASE WHEN FIND_IN_SET(4, s.'. strtolower($todayDay) .') THEN "Leave" ELSE "Active" END AS status';
        
        $joins = [
            'shifts sh' => 'FIND_IN_SET(sh.shift_id, s.' . strtolower($todayDay) . ')', 
        ];
        
        // Fetch the data
        return $this->db->getData($table, $conditions, $fields, $joins);
    }
    

}