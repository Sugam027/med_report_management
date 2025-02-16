<?php

class prescription extends BaseController{

    private $appointmentModel;
    private $prescriptionModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        // Load the User and Role models
        $this->appointmentModel = $this->model('Appointments');
        $this->prescriptionModel = $this->model('Prescriptions');
        $this->userModel = $this->model('Users');
    }
    public function index() {
        $this->auth_route->checkPermission([1,2,3]);
        $userId = $_SESSION['user_id']; // Get the logged-in user's ID
        $userRoleId = $_SESSION['role_id'];
        $patients = null;
        
        
        if ($userRoleId === 1) {
            // Admin: Fetch all appointments
            $patients = $this->userModel->getPatients();
            $prescriptions = $this->appointmentModel->getAllAppointments();
        } elseif($userRoleId === 2) {
            // Doctor: Fetch only appointments assigned to them
            $patients = $this->userModel->getPatientsByDoctorId($userId);
        } else{
            
            $prescriptions = $this->prescriptionModel->getPrescriptionByUser($userId);
        }
        
        $data = [
            'prescriptions' => $prescriptions,
            'patients' => $patients
    ];
    
        $this->view('prescription/index', $data);
    }
   
    public function add($appointmentId = null) {
        $this->auth_route->checkPermission([1,2]);
    
        // Validate appointment ID
        if (empty($appointmentId) || !is_numeric($appointmentId)) {
            header('Location: /appointment');
            exit;
        }
    
        // Fetch the appointment details
        $appointment = $this->appointmentModel->getAppointmentById($appointmentId);
    
        if (!$appointment || !isset($appointment[0])) {
            header('Location: /appointment');
            exit;
        }
    
        $appointment = $appointment[0]; // Access the first element
        $data = ['appointment' => $appointment];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Extract data from the form
            $appointmentId = $_POST['appointment_id'];
            $symptoms = $_POST['symptoms'];
            $bloodPressure = $_POST['blood_pressure'];
            $temperature = $_POST['temperature'];
            $heartRate = $_POST['heart_rate'];
            $examinationDetail = $_POST['examination_detail'];
            $disease = $_POST['disease'];
            $followUpDate = $_POST['follow_up_date'];
            $followUpTime = $_POST['follow_up_time'];
    
            // Start Transaction
    
            try {
                // **1. Insert into `prescriptions` table**
                $prescriptionData = [
                    'appointment_id' => $appointmentId,
                    'symptoms' => $symptoms,
                    'blood_pressure' => $bloodPressure,
                    'temperature' => $temperature,
                    'heart_rate' => $heartRate,
                    'examination_detail' => $examinationDetail,
                    'disease' => $disease
                ];
    
                // **2. Insert Medicines into `prescription_medicines`**
                if (!empty($_POST['medicines'])) {
                    $medicineData = []; // Initialize array
                    foreach ($_POST['medicines'] as $index => $medicine) {
                        if (!empty($medicine)) {
                            $medicineData[] = [
                                'medicine_name' => $medicine,
                                'instructions' => $_POST['instructions'][$index] ?? ''
                            ];
                        }
                    }
                }
                
                if (!empty($_POST['test_name'])) {
                    $testData = []; // Initialize array
                    foreach ($_POST['test_name'] as $index => $testName) {
                        if (!empty($testName)) {
                            $testFile = !empty($_FILES['test_files']['name'][$index]) ? $this->uploadFile($_FILES['test_files'], $index) : null;
                
                            $testData[] = [
                                'test_name' => $testName,
                                'test_result' => $_POST['test_result'][$index] ?? '',
                                'test_file' => $testFile
                            ];
                        }
                    }
                }
                

                if(!empty($followUpDate)){
                    $appointmentData = [
                        'date' => $followUpDate,
                        'time' => $followUpTime,
                        'patient_id' => $appointment['patient_id'],
                        'patient_name' => $appointment['patient_name'],
                        'phone' => $appointment['phone'],
                        'symptoms' => $symptoms,
                        'department_id' => $appointment['department_id'],
                        'doctor_id' => $appointment['doctor_id']
                    ];
                }
                try {
                     $result = $this->prescriptionModel->add($prescriptionData, $medicineData, $testData, $appointmentData);
                    if ($result) {
                        $this->auth_route->setSessionMessage(true, 'Prescription added successfully.');
                    } else {
                        $this->auth_route->setSessionMessage(false, 'Prescription addition failed. Please try again.');
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    $this->auth_route->setSessionMessage(false, 'Prescription addition  failed. Please try again.');
                }
                $this->auth_route->redirect('appointment');
                exit;
            } catch (Exception $e) {
                $this->prescriptionModel->rollback();
                die("Error: " . $e->getMessage());
            }
        }
    
        $this->view('prescription/add', $data);
    }
    
    /**
     * Handle file uploads
     */
    private function uploadFile($files, $index) {
        $uploadDir = 'uploads/test_results/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        $fileName = basename($files['name'][$index]);
        // Remove spaces and special characters from the file name
        $fileNameWithoutSpaces = preg_replace('/\s+/', '_', $fileName); // Replace spaces with underscores
        $fileNameWithoutSpaces = preg_replace('/[^A-Za-z0-9_.]/', '', $fileNameWithoutSpaces); // Remove special characters
        $targetFilePath = $uploadDir . $fileNameWithoutSpaces;
    
        if (move_uploaded_file($files['tmp_name'][$index], $targetFilePath)) {
            return $fileName;
        }
        return null;
    }
    
    
    public function viewPatient($patientId = null){
        if (empty($patientId) || !is_numeric($patientId)) {
            $this->auth_route->redirect('/prescription');
        }
        $userId = $_SESSION['user_id']; // Get the logged-in user's ID
        $userRoleId = $_SESSION['role_id'];
        // $patientId = 1072;

        if ($userRoleId === 1) {
            // Admin: Fetch all appointments
            $patients = $this->userModel->getLoginUser($patientId);;
            $prescriptions = $this->prescriptionModel->getPrescriptionByUser($patientId);
        } elseif($userRoleId === 2) {
            // Doctor: Fetch only appointments assigned to them
            $patients = $this->userModel->getLoginUser($patientId);
            $prescriptions = $this->prescriptionModel->getPrescriptionByUser($patientId);
            // $prescriptions = $this->prescriptionModel->getAppointmentsByDoctor($userId);
        } else{
            $prescriptions = $this->prescriptionModel->getPrescriptionByUser($userId);
        }

        $data=[
            'patients' => $patients,
            'prescriptions' => $prescriptions
        ];

        $this->view('prescription/viewpatient', $data);
    }


}