<?php
// require_once __DIR__ . '/../core/Sql.php';
class Prescriptions{
    private $db;
    public function __construct() {
        $this->db = new Sql();
        $this->auth_route = new AuthRoute();
    }
    

    // last userId
    // public function lastInsertedId(){
    //     $this->db->query("SELECT user_id FROM users");

    // }

    public function add($prescriptionData) {
        try {
            // Insert into users table
            // return $this->db->insertData('prescriptions', $prescriptionData); 
            $result = $this->db->insertData('prescriptions', $prescriptionData);

            if ($result) {
                // Fetch the associated appointment details
                $appointmentId = $prescriptionData['appointment_id'];
                $this->db->query("SELECT patient_id FROM appointments WHERE appointment_id = :appointment_id");
                $this->db->bind(':appointment_id', $appointmentId);
                $appointment = $this->db->single();
    
                if ($appointment) {
                    $patientId = $appointment['patient_id'];
                    // Create a notification for the patient
                    $notificationData = [
                        'user_id' => $patientId,
                        'message' => 'A new prescription has been added for your appointment.',
                    ];
                    $this->db->insertData('notifications', $notificationData);
                }
            }
    
            return $result;
            
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            error_log("Registration failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }

    public function getPrescriptionByUser($userId)
    {
        $table = 'prescriptions p';
        $conditions = ['a.patient_id' => $userId]; 
        $fields = 'p.prescription_id, p.appointment_id, p.examination_detail, p.medicine_name, p.instructions, a.date, a.patient_name, a.phone, a.symptoms, a.department_id, a.doctor_id, u.image AS doctor_image,u.name AS doctor_name, u.email AS doctor_email, dd.department_id, depart.name AS department_name, a.updated_at';
        $joins = ['appointments a' => 'p.appointment_id = a.appointment_id', 'users u' => 'a.doctor_id = u.user_id', 'doctor_details dd' => 'a.doctor_id = dd.user_id', 'departments depart' => 'depart.id = a.department_id' ];
        $orderBy = "updated_at DESC";
        // Fetch the data
        return $this->db->getData($table, $conditions, $fields, $joins,'', $orderBy);
        

    }
    
   
    

}