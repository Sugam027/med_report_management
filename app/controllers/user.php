<?php
class user extends Controller{
    private $userModel;
    private $roleModel;

    public function __construct() {
        // Load the User and Role models
        $this->userModel = $this->model('Users');
        $this->roleModel = $this->model('Roles');
    }

    public function registeruser() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect form data
        // echo '<pre>'; print_r($_POST); echo '</pre>'; 
        $userData = [
            'username' => trim($_POST['username']),
            'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone']),
            'name' => trim($_POST['full_name']),
            'role_id' => trim($_POST['role'])
        ];

        $userDetailsData = [
            'full_name' => trim($_POST['full_name']),
            'phone' => trim($_POST['phone']),
            'dob' => trim($_POST['dob']),
            'age' => trim($_POST['age']),
            'gender' => trim($_POST['gender']),
            'blood_group' => trim($_POST['blood_group']),
            'father_name' => trim($_POST['father_name']),
            'mother_name' => trim($_POST['mother_name']),
            'is_minor' => isset($_POST['is_minor']) ? 1 : 0,
            'permanent_address' => trim($_POST['permanent_address']),
            'temporary_address' => trim($_POST['temporary_address'])
        ];

        // Check if the role is for a doctor, then collect doctor details
        $doctorDetailsData = null;
        if ($_POST['role'] == 2) { // Replace 'doctor_role_id' with the actual doctor role ID
            $doctorDetailsData = [
                'department' => trim($_POST['department']),
                'license_number' => trim($_POST['license_number']),
                'experience_years' => trim($_POST['experience_years'])
            ];
        }

        // Register user
        try {
            $result = $this->userModel->register($userData, $userDetailsData, $doctorDetailsData);
            if ($result) {
                // Set success message
                $data['success'] = 'User registered successfully.';
            } else {
                // Set error message
                $data['error'] = 'Registration failed. Please try again.' ;
            }
        } catch (Exception $e) {
            // Log the error for debugging
            error_log($e->getMessage());
            // Set error message
            $data['error'] = 'An error occurred during registration: ' . $e->getMessage();
        }
    }

    // Load the view with data
    $roles = $this->roleModel->getRoles(); // Get roles to display
     $data = [
         'roles' => $roles,
         'success' => $_SESSION['success'] ?? null,
         'error' => $_SESSION['error'] ?? null,
     ];
 
     // Clear session messages after loading
     unset($_SESSION['success'], $_SESSION['error']);
    $this->view('user/registeruser', $data);
    }

    public function viewdoctor() {
        $doctors = $this->userModel->getDoctors();  // Get all doctors
        $data = [
            'doctors' => $doctors,
        ];

        $this->view('user/viewdoctor', $data);
    }
    public function viewpatient() {
        $patients = $this->userModel->getPatients(); // Get all patients
        $data = [
            'patients' => $patients,
        ];
        $this->view('user/viewpatient', $data);
    }
    
    
    
}