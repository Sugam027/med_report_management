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
            // $prescriptions = $this->prescriptionModel->getAppointmentsByDoctor($userId);
        } else{
            
            $prescriptions = $this->prescriptionModel->getPrescriptionByUser($userId);
        }
        
        // print_r($prescriptions);
        
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
    
        // Check if appointment data exists and if it is an array with data
        if (!$appointment || !isset($appointment[0])) {
            // If no appointment found, redirect to the appointment page or handle error
            header('Location: /appointment');
            exit;
        }
    
        // Unwrap the array and pass the appointment data to the view
        $appointment = $appointment[0]; // Access the first element of the array
        $data =[
            'appointment' => $appointment
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentId = $_POST['appointment_id'];
            $disease = $_POST['disease'];
            $examinationDetail = $_POST['examination_detail'];
            $medicines = $_POST['medicines'];
            $instructions = $_POST['instructions'];
    
            foreach ($medicines as $index => $medicine) {
                if (!empty($medicine)) {
                    $prescriptionData = [
                        // 'prescription_id' => $prescriptionId,
                        'appointment_id' => $appointmentId,
                        'disease' => $disease,
                        'examination_detail' => $examinationDetail,
                        'medicine_name' => $medicine,
                        'instructions' => $instructions[$index]
                    ];
                    $this->prescriptionModel->add($prescriptionData);
                }
            }
        }
        $this->view('prescription/add', $data);
    
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
        // print_r($prescriptions);

        $data=[
            'patients' => $patients,
            'prescriptions' => $prescriptions
        ];

        $this->view('prescription/viewpatient', $data);
    }


}