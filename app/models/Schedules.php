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
            $result = $this->db->insertData('doctor_schedule', $scheduleData);
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

    public function updateSchedule($scheduleData, $userId){
        try {
            $this->db->beginTransaction();
            print_r($scheduleData);

            $conditions = ['user_id' => $userId];
            $updateData = $scheduleData;
        unset($updateData['user_id']);

    
            // Insert schedule into the doctor_schedule table
            $result = $this->db->updateData('doctor_schedule', $scheduleData, $conditions);
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
    
    
    public function getScheduleWithShifts($todayDay) {
        $table = 'doctor_schedule s';
        $conditions = []; // No specific conditions for the table
        $fields = 's.user_id,s.doctor_name, sh.title AS shift, sh.start_time, sh.end_time, 
                   CASE WHEN FIND_IN_SET(4, s.'. strtolower($todayDay) .') THEN "Leave" ELSE "Active" END AS status';
        
        $joins = [
            'shifts sh' => 'FIND_IN_SET(sh.shift_id, s.' . strtolower($todayDay) . ')', 
        ];
        
        // Fetch the data
        return $this->db->getData($table, $conditions, $fields, $joins);
    }

    public function getScheduleById() {
        
        // $condition= ['user_id' => $userId];   
        // $fields = 'user_id';

        $result= $this->db->getData('doctor_schedule');
        // print_r($result);
        return $result;
    }
        
    public function getDoctorSchedule($doctorId) {
        
        $conditions= ['user_id' => $doctorId];   

        $result= $this->db->getSingleData('doctor_schedule', $conditions);
        // print_r($result);
        return $result;
        
    }
    

}