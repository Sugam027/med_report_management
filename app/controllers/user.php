<?php
class user extends BaseController{
    private $db;
    private $userModel;
    private $roleModel;
    private $departmentModel;

    public function __construct() {
        parent::__construct();
        $this->db = new Sql();
        // Load the User and Role models
        $this->userModel = $this->model('Users');
        $this->roleModel = $this->model('Roles');
        $this->departmentModel = $this->model('Departments');
    }

    public function registeruser() {
        $this->auth_route->checkPermission([1]);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $userData = [
                'username' => trim($_POST['username']),
                'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'image' => 'user.png',
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
                'permanent_address' => trim($_POST['permanent_address']),
                'temporary_address' => trim($_POST['temporary_address'])
            ];

            // Check if the role is for a doctor, then collect doctor details
            $doctorDetailsData = null;
            if ($_POST['role'] == 2) { // Replace 'doctor_role_id' with the actual doctor role ID
                $doctorDetailsData = [
                    'department_id' => trim($_POST['department_id']),
                    'license_number' => trim($_POST['license_number']),
                    'experience_years' => trim($_POST['experience_years'])
                ];
            }

            // Register user
            try {
                $result = $this->userModel->register($userData, $userDetailsData, $doctorDetailsData);
                if ($result) {
                    // Set success message
                    // echo "$result";
                    $this->auth_route->setSessionMessage(true, 'User registered successfully.');
                    // echo '<pre>'; print_r($doctorDetailsData); echo '</pre>'; 
                    // Send email to the registered user
                    $mailer = new Mailer();
                    $plainPassword = trim($_POST['password']); // Get the original password before hashing
                    $mailData = [
                        'name' => $userData['name'],
                        'username' => $userData['username'],
                        'password' => $plainPassword,
                        'email' => $userData['email']
                    ];
                    if ($mailer->accountCreationMail($mailData)) {
                        $this->auth_route->setSessionMessage(true, 'User registered and an email with login credentials has been sent.');
                    } else {
                        $this->auth_route->setSessionMessage(false, 'User registered, but the email could not be sent.');
                    }
                } else {
                    // Set error message
                    $this->auth_route->setSessionMessage(false, 'Registration failed. Please try again.');
                }
            } catch (Exception $e) {
                // Log the error for debugging
                error_log($e->getMessage());
                // Set error message
                $this->auth_route->setSessionMessage(false, 'Registration failed. Please try again.');
            }
        }
        // Load the view with data
        $roles = $this->roleModel->getRoles(); // Get roles to display
        $departments = $this->departmentModel->getDepartments(); // Get roles to display
        $data = [
            'roles' => $roles,
            'departments' => $departments,
        ];
        $this->view('user/registeruser', $data);
    }

    public function updateprofile(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $userId = $_SESSION['user_id']; // Assuming the user ID is stored in the session
            $imageFile = $_FILES['image'];

            $targetDir = "uploads/profile_images/";
            $imageName = basename($imageFile['name']);
            $targetFilePath = $targetDir . $imageName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($imageFile['tmp_name'], $targetFilePath)) {
                // Update the user's image in the database
                
                if ($this->userModel->updateProfileImage($userId, $imageName)) {
                    $this->auth_route->setSessionMessage(true, 'Profile image updated successfully!');
                    $this->auth_route->redirect('dashboard');
                } else {
                    $this->auth_route->setSessionMessage(false, 'Failed to update profile image.');
                }
            } else {
                $this->auth_route->setSessionMessage(false, 'Failed to update profile image.');
            }
        
            
        }
    }

    public function edituser() {
        $this->auth_route->checkPermission([1,2,3]);
        $userId = $_GET['user_id'];
        $loggedUserId = $_SESSION['user_id'];

        // Check if the logged-in user has permission to edit this user
        if ($_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3) {
            // If the role is 2 or 3, they can only edit their own profile
            if ($loggedUserId != $userId) {
                // If the user is trying to edit someone else's profile, redirect
                header('Location: /user/edituser?user_id=' . $loggedUserId); // Redirect to their own profile
                exit;
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userData = [
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
            ];

            $userDetailsData = [
                'phone' => trim($_POST['phone']),
                'dob' => trim($_POST['dob']),
                'age' => trim($_POST['age']),
                'gender' => trim($_POST['gender']),
                'blood_group' => trim($_POST['blood_group']),
                'father_name' => trim($_POST['father_name']),
                'mother_name' => trim($_POST['mother_name']),
                'permanent_address' => trim($_POST['permanent_address']),
                'temporary_address' => trim($_POST['temporary_address'])
            ];

            // Check if the role is for a doctor, then collect doctor details
            $doctorDetailsData = null;
            if ($_POST['role'] == 2) { // Replace 'doctor_role_id' with the actual doctor role ID
                $doctorDetailsData = [
                    'department_id' => trim($_POST['department_id']),
                    'license_number' => trim($_POST['license_number']),
                    'experience_years' => trim($_POST['experience_years'])
                ];
            }

            // Register user
            try {
                $result = $this->userModel->edit($userId, $userData, $userDetailsData, $doctorDetailsData);
                if ($result) {
                    $this->auth_route->setSessionMessage(true, 'User Updated successfully.');
                } else {
                    // Set error message
                    $this->auth_route->setSessionMessage(false, 'Updatation failed. Please try again.');
                }
            } catch (Exception $e) {
                // Log the error for debugging
                error_log($e->getMessage());
                // Set error message
                $this->auth_route->setSessionMessage(false, 'Updatation failed. Please try again.');
            }
            // $this->auth_route->redirect('user/registeruser');
        }

        // Load the view with data
        $roles = $this->roleModel->getRoles(); // Get roles to display
        $departments = $this->departmentModel->getDepartments(); // Get roles to display
        $user = $this->userModel->getUserById($userId);
        $data = [
            'roles' => $roles,
            'departments' => $departments,
            'user' => $user
        ];
    
        $this->view('user/edituser', $data);
    }

    public function viewdoctor() {
        $this->auth_route->checkPermission([1,2]);
        $doctors = $this->userModel->getDoctors();  // Get all doctors
        $data = [
            'doctors' => $doctors,
        ];

        $this->view('user/viewdoctor', $data);
    }
    public function viewpatient() {
        $this->auth_route->checkPermission([1,2]);
        $userRoleId = $_SESSION['role_id'];
        $doctorId = $_SESSION['user_id'];
        $patients = $this->userModel->getPatients(); // Get all patients
        if($userRoleId === 2){
            $patients = $this->userModel->getPatientsByDoctorId($doctorId);
        }
        $data = [
            'patients' => $patients,
        ];
        $this->view('user/viewpatient', $data);
    }

    
    public function deactiveuser($userId = null){
        $this->auth_route->checkPermission([1]);
        if (empty($userId) || !is_numeric($userId)) {
            $this->auth_route->redirect('user/viewpatient');
            exit;

        }
        // $user = $this->userModel->getUserById($userId);
    
        // Check if user data exists
        if (!$userId) {
            // If no user found, redirect to the user page or handle error
            $this->auth_route->redirect('user/viewpatient');
            exit;
        }

        $result = $this->db->deactivateData('users', ['user_id' => $userId]);

        if ($result) {
            $this->auth_route->setSessionMessage(true, "User deactivated!");
            $this->auth_route->redirect('user/viewpatient');
        } else {
            $this->auth_route->setSessionMessage(false, "Failed to deactive the user.");
            $this->auth_route->redirect('user/viewpatient');
        }
    }
    public function activeuser($userId = null){
        $this->auth_route->checkPermission([1]);
        if (empty($userId) || !is_numeric($userId)) {
            $this->auth_route->redirect('user/viewpatient');
            exit;

        }
        // $user = $this->userModel->getUserById($userId);
    
        // Check if user data exists
        if (!$userId) {
            // If no user found, redirect to the user page or handle error
            $this->auth_route->redirect('user/viewpatient');
            exit;
        }

        $result = $this->db->restoreData('users', ['user_id' => $userId]);

        if ($result) {
            $this->auth_route->setSessionMessage(true, "User activated!");
            $this->auth_route->redirect('user/viewpatient');
        } else {
            $this->auth_route->setSessionMessage(false, "Failed to active the user.");
            $this->auth_route->redirect('user/viewpatient');
        }
    }
    public function profile(){
        $this->auth_route->checkPermission([1, 2, 3]);
        $userId = $_GET['user_id'];
        if (empty($userId) || !is_numeric($userId)) {
            $this->auth_route->redirect('dashboard');
            exit;

        }
        $user = $this->userModel->getUserById($userId);
        $data = [
            'user' => $user,
        ];
        $this->view('user/profile', $data);
    }
    
    
    
}