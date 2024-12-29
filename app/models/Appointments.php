<?php
// require_once __DIR__ . '/../core/Sql.php';
class Appointments{
    private $db;
    public function __construct() {
        $this->db = new Sql();
        $this->auth_route = new AuthRoute();
    }
    

    // last userId
    public function lastInsertedId(){
        $this->db->query("SELECT user_id FROM users");

    }

    public function getAppointmentsByDoctor($doctorId)
    {
        $table = 'appointments';
        $conditions = ['doctor_id' => $doctorId]; // No specific conditions for the table
        $fields = '*';
        $joins = [];
        
        // Fetch the data
        return $this->db->getData($table, $conditions, $fields, $joins);
    }
    public function getAppointmentsByUser($userId)
    {
        $table = 'appointments';
        $conditions = ['patient_id' => $userId, 'status' => 0]; // No specific conditions for the table
        $fields = '*';
        
        // Fetch the data
        return $this->db->getData($table, $conditions, $fields);
    }

    public function getAppointmentById($appointmentId){
        $table = 'appointments';
        $condition = ['appointment_id' => $appointmentId];
        $fields = "*";
        $joins = [];

        return $this->db->getData($table, $condition, $fields, $joins);
        
    }
    public function getAllAppointments()
    {
        $table = 'appointments a';
        $conditions = []; // No specific conditions for the table
        $fields = 'a.*, u.name AS doctor_name';
        
        $joins = [
            'users u' => 'a.doctor_id = u.user_id', 
        ];
        
        // Fetch the data
        return $this->db->getData($table, $conditions, $fields, $joins);
    }

    // Insert user data into all three tables
    public function createAppointment($appointmentData) {
        try {
            $this->db->beginTransaction();
            // Insert into users table
            $appointmentId = $this->db->insertData('appointments', $appointmentData); 

            if ($appointmentId) {
                // Create notification for doctor
                $doctorNotification = [
                    'user_id' => $appointmentData['doctor_id'],
                    'message' => 'You have a new appointment scheduled with ' . $appointmentData['patient_name'] . ' on ' . $appointmentData['date'] . ' at ' . $appointmentData['time'] . '.',
                ];
                $this->db->insertData('notifications', $doctorNotification);
    
                // Create notification for user (patient)
                $userNotification = [
                    'user_id' => $appointmentData['patient_id'],
                    'message' => 'Your appointment has been scheduled with Dr. ' . $appointmentData['doctor_id'] . ' on ' . $appointmentData['date'] . ' at ' . $appointmentData['time'] . '.',
                ];
                $this->db->insertData('notifications', $userNotification);
    
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
            error_log("Appointment schedule failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }
    public function updateStatus($id, $status) {
        try {
            $data = ['status' => $status];
            $conditions = ['appointment_id' => $id];

            // Update into appointments table
            return $this->db->updateData('appointments', $data, $conditions); 
            
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            error_log("Appointment schedule failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }
    
    
    

}