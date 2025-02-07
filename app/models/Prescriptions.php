<?php
// require_once __DIR__ . '/../core/Sql.php';
class Prescriptions{
    private $db;
    public function __construct() {
        $this->db = new Sql();
        $this->auth_route = new AuthRoute();
    }
    
    public function add($prescriptionData ,$medicineData, $testData, $appointmentData) {
        try {
            $this->db->beginTransaction();

            $prescriptionId = $this->db->insertData('prescriptions', $prescriptionData);
            
            if ($prescriptionId) {
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

            if (!empty($medicineData)) {
                foreach ($medicineData as $medicine) {
                    $medicine['prescription_id'] = $prescriptionId;  // Add prescription_id to each record
                    $this->db->insertData('prescription_medicines', $medicine);
                }
            }
            
            if (!empty($testData)) {
                foreach ($testData as $test) {
                    $test['prescription_id'] = $prescriptionId;  // Add prescription_id to each record
                    $this->db->insertData('test_results', $test);
                }
            }

            if ($appointmentData) {
                $this->db->insertData('appointments', $appointmentData);
            }

            $this->db->commit();
            if($prescriptionId){
                return true;
            }else{
                return false;
            }
            
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            $this->db->rollBack();
            error_log("Prescription addition failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }

    public function getPrescriptionByUser($userId)
    {
        $table = 'prescriptions p';
        $conditions = ['a.patient_id' => $userId]; 
        $fields = 'p.prescription_id, p.appointment_id, p.disease, p.symptoms, p.blood_pressure, p.temperature, p.heart_rate, p.examination_detail, 
        GROUP_CONCAT(DISTINCT pm.medicine_name ORDER BY pm.medicine_name ASC SEPARATOR ", ") AS medicine_names, 
        GROUP_CONCAT(DISTINCT pm.instructions ORDER BY pm.instructions ASC SEPARATOR ", ") AS medicine_instructions,
        GROUP_CONCAT(DISTINCT t.test_name ORDER BY t.test_name ASC SEPARATOR ", ") AS test_names, 
        GROUP_CONCAT(DISTINCT t.test_result ORDER BY t.test_result ASC SEPARATOR ", ") AS test_results, 
        GROUP_CONCAT(DISTINCT t.test_file ORDER BY t.test_file ASC SEPARATOR ", ") AS test_files,
        a.date, a.patient_name, a.phone, a.symptoms, a.department_id, a.doctor_id, 
        u.image AS doctor_image, u.name AS doctor_name, u.email AS doctor_email, 
        dd.department_id, depart.name AS department_name, a.updated_at';
        
        $joins = [
            'appointments a' => 'p.appointment_id = a.appointment_id',
            'prescription_medicines pm' => 'p.prescription_id = pm.prescription_id',
            'test_results t' => 'p.prescription_id = t.prescription_id',
            'users u' => 'a.doctor_id = u.user_id',
            'doctor_details dd' => 'a.doctor_id = dd.user_id',
            'departments depart' => 'depart.id = a.department_id'
        ];
        
        $groupBy = "p.prescription_id";
        $orderBy = "a.updated_at DESC";

        return $this->db->getData($table, $conditions, $fields, $joins, $groupBy, $orderBy);
    }


    public function getPrescriptionByAppointmentId($appointmentId)
    {
        $table = 'prescriptions p';
        $conditions = ['a.appointment_id' => $appointmentId]; 
        $fields = '
            u.email AS patient_email, 
            ud.blood_group,
            ud.gender,
            ud.permanent_address,
            ud.temporary_address,
            udoc.phone AS doctor_phone, 
            p.prescription_id, p.appointment_id, p.disease, p.symptoms, p.blood_pressure, p.temperature, p.heart_rate, p.examination_detail, 
            GROUP_CONCAT(DISTINCT pm.medicine_name ORDER BY pm.medicine_name ASC SEPARATOR ", ") AS medicine_names, 
            GROUP_CONCAT(DISTINCT pm.instructions ORDER BY pm.instructions ASC SEPARATOR ", ") AS medicine_instructions,
            GROUP_CONCAT(DISTINCT t.test_name ORDER BY t.test_name ASC SEPARATOR ", ") AS test_names, 
            GROUP_CONCAT(DISTINCT t.test_result ORDER BY t.test_result ASC SEPARATOR ", ") AS test_results, 
            GROUP_CONCAT(DISTINCT t.test_file ORDER BY t.test_file ASC SEPARATOR ", ") AS test_files,
            a.date, a.patient_id, a.age, a.patient_name, a.phone, a.symptoms, a.doctor_id, 
            u.image AS doctor_image, u.name AS doctor_name, u.email AS doctor_email, 
            dd.department_id, depart.name AS department_name, a.updated_at'
        ;
        $joins = ['appointments a' => 'p.appointment_id = a.appointment_id', 'prescription_medicines pm' => 'p.prescription_id = pm.prescription_id', 'test_results t' => 't.prescription_id = t.prescription_id', 'users u' => 'a.patient_id = u.user_id', 'users udoc' => 'a.doctor_id = udoc.user_id', 'doctor_details dd' => 'a.doctor_id = dd.user_id','user_details ud' => 'a.patient_id = ud.user_id', 'departments depart' => 'depart.id = a.department_id' ];
        // Fetch the data
        return $this->db->getData($table, $conditions, $fields, $joins,'');
        

    }
    
   
    

}