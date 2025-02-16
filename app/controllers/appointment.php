<?php

class appointment extends BaseController{
    private $userModel;
    private $appointmentModel;
    private $departmentModel;


    public function __construct() {
        parent::__construct();
        // Load the User and Role models
        $this->userModel = $this->model('Users');
        $this->appointmentModel = $this->model('Appointments');
        $this->departmentModel = $this->model('Departments');
    }

    
    public function index() {
        $this->auth_route->checkPermission([1,2,3]);
        $userId = $_SESSION['user_id']; // Get the logged-in user's ID
        $userRoleId = $_SESSION['role_id'];
        $today = date('Y-m-d');
        $pastAppointments = [];
        $todaysAppointments = [];
        $upcomingAppointments = [];

        

        
        // Fetch appointments based on role
        if ($userRoleId === 1) {
            // Admin: Fetch all appointments
            $appointments = $this->appointmentModel->getAllAppointments();
        } elseif($userRoleId === 2) {
            // Doctor: Fetch only appointments assigned to them
            $appointments = $this->appointmentModel->getAppointmentsByDoctor($userId);
        } else{
            $appointments = $this->appointmentModel->getAppointmentsByUser($userId);
        }

        foreach ($appointments as $appointment) {
            // Convert appointment date to 'Y-m-d'
            $appointmentDate = date('Y-m-d', strtotime($appointment['date']));
            
            if ($appointmentDate === $today) {
                $todaysAppointments[] = $appointment;
            } else {
                $otherAppointments[] = $appointment;
            }
        }

        
        $data = [
            'appointments' => $appointments,
            'todaysAppointments' => $todaysAppointments,
            'otherAppointments' => $otherAppointments
        ];

        // print_r($data['pastAppointments']);
        
    
        // Load the view with the data
        $this->view('appointment/index', $data);
    }
    public function create() {
        $this->auth_route->checkPermission([1,3]);

        // $doctors = $this->userModel->getDoctors();  // Get all doctors
        $departments = $this->departmentModel->getDepartments();  
        // $departDoctor = $this->departmentModel->getDoctorByDepartment();  // Get all doctors

        
        // Initialize feedback messages
        $data = [
            // 'doctors' => $departDoctor,
            'departments' => $departments
        ];
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Fetch input data
            $patientName = $_POST['patient_name'];
            $patientPhone = $_POST['phone'];
    
            // Fetch user_id based on name or phone
            $user_id = $this->userModel->getUserIdByIdentifier($patientName, $patientPhone);
    
            if ($user_id) {
                // Prepare data for appointment
                $appointmentData = [
                    'date'            => $_POST['date'],
                    'time'            => $_POST['time'],
                    'patient_id'      => $user_id,
                    'patient_name'    => $patientName,
                    'age'             => $_POST['age'],
                    'phone'           => $patientPhone,
                    'symptoms'        => $_POST['symptoms'],
                    'department_id' => $_POST['department_id'],
                    'doctor_id'       => $_POST['doctor_id']
                ];
                // print_r($appointmentData);
    
                // Call model to insert appointment data
                $result = $this->appointmentModel->createAppointment($appointmentData);
                if ($result) {
                    // $this->auth_route->setSessionMessage(true, 'Appointment created successfully. ');
                    $this->auth_route->setSessionMessage(true,'Appointment created successfully.');
                } else {
                    
                    $this->auth_route->setSessionMessage(false,'Failed to schedule the appointment.');
                }
            } else {
                $this->auth_route->setSessionMessage(false,'Patient not found! Please verify the name and phone number.');
            }
        }
    
        // Load the view with the data
        $this->view('appointment/create', $data);
    }
    public function updateStatus(){
        $this->auth_route->checkPermission([1,2,3]);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the appointment ID and status from the form submission
            $appointmentId = $_POST['appointment_id'];
            $status = filter_var($_POST['status'], FILTER_VALIDATE_BOOLEAN);

            // Call the model to update the status
            $result = $this->appointmentModel->updateStatus($appointmentId, $status);

            if ($result) {
                $this->auth_route->setSessionMessage(true,"Appointment status updated successfully.");
            } else {
                $this->auth_route->setSessionMessage(false,"Failed to update appointment status.");
            }

            // Redirect back to the appointments page
            header("Location: /appointment/index");
            exit;
        }
    }

    public function getDoctorsByDepartment($departmentId) {
        $this->auth_route->checkPermission([1,2,3]);
        // Fetch doctors based on the department ID
        $doctors = $this->departmentModel->getDoctorByDepartment($departmentId);
    
        // Return the doctors in JSON format
        echo json_encode($doctors);
        exit;
    }

    
}