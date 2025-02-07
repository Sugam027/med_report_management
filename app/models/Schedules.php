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
    public function insertSchedule($scheduleData) {
        try {
            $this->db->beginTransaction();
    
            // Insert schedule into the doctor_schedule table
            $result = $this->db->insertData('doctor_schedules', $scheduleData);
            if ($result) {
                // Create notification for the doctor
                $doctorNotification = [
                    'user_id' => $scheduleData['user_id'],
                    'message' => 'Your schedule has been updated.',
                ];
                $this->db->insertData('notifications', $doctorNotification);
    
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            // $this->db->rollBack();
            error_log("Error in updateSchedule: " . $e->getMessage());
            return false;
        }
    }

    public function updateSchedule($scheduleData, $userId){
        try {
            $this->db->beginTransaction();

            $conditions = ['user_id' => $userId];
            $updateData = $scheduleData;
        unset($updateData['user_id']);

    
            // Insert schedule into the doctor_schedule table
            $result = $this->db->updateData('doctor_schedules', $scheduleData, $conditions);
            // print_r($result);
            if ($result) {
                // Create notification for the doctor
                $doctorNotification = [
                    'user_id' => $scheduleData['user_id'],
                    'message' => 'Your schedule has been updated.',
                ];
                $this->db->insertData('notifications', $doctorNotification);
    
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            // $this->db->rollBack();
            error_log("Error in updateSchedule: " . $e->getMessage());
            return false;
        }
    }
    
    
    public function getScheduleWithShifts($todayDay, $todayTime) {
        $table = 'doctor_schedules s';
        $conditions = []; // No specific conditions for the table
        $fields = 's.user_id, 
                s.doctor_name, 
                GROUP_CONCAT(sh.title ORDER BY sh.start_time) AS shifts,
                GROUP_CONCAT(sh.start_time ORDER BY sh.start_time) AS start_time,
                GROUP_CONCAT(sh.end_time ORDER BY sh.start_time) AS end_time, 
                CASE 
                    WHEN MAX(CASE WHEN FIND_IN_SET(sh.shift_id, s.' . strtolower($todayDay) . ') 
                                AND "' . $todayTime . '" BETWEEN sh.start_time AND sh.end_time THEN 1 ELSE 0 END) = 1 
                    THEN "Available"
                    ELSE "Leave"
                END AS status';
    
        $joins = [
            'shifts sh' => 'FIND_IN_SET(sh.shift_id, s.' . strtolower($todayDay) . ')',
        ];
        $groupBy = 's.user_id, s.doctor_name';
        $orderBy = 's.doctor_name';
        
        return $this->db->getData($table, $conditions, $fields, $joins, $groupBy, $orderBy);
    }

    public function getScheduleById() {
        
        // $condition= ['user_id' => $userId];   
        // $fields = 'user_id';

        $result= $this->db->getData('doctor_schedules');
        // print_r($result);
        return $result;
    }
        
    public function getDoctorSchedule($doctorId) {
        
        $conditions= ['user_id' => $doctorId];   

        $result= $this->db->getSingleData('doctor_schedules', $conditions);
        // print_r($result);
        return $result;
        
    }
    

}