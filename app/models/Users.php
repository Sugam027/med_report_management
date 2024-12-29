<?php
// require_once __DIR__ . '/../core/Sql.php';
class Users{
    private $db;
    public function __construct() {
        $this->db = new Sql();
        $this->auth_route = new AuthRoute();
    }
    

    // last userId
    public function lastInsertedId(){
        $this->db->query("SELECT user_id FROM users");

    }

    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        return $this->db->single();  // Return single user record

        if ($row) {
            // Verify password
            if (password_verify($password, $row->password)) {
                return $row;  // Return the user data
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUserIdByIdentifier($patientName, $patientPhone) {
        $sql = "SELECT user_id FROM users WHERE name = :patientName AND phone = :patientPhone LIMIT 1";
        $this->db->query($sql);
        $this->db->bind(':patientName', $patientName);
        $this->db->bind(':patientPhone', $patientPhone);
    
        $row = $this->db->single();
        return $row ? $row['user_id'] : null;
    }

    public function getLoginUser($userId){
        $table = 'users u';
        $conditions =['u.user_id' => $userId];
        $fields = 'u.*, dd.*, ud.*';
        $joins = ['user_details ud' => 'ud.user_id = u.user_id', 'doctor_details dd' => 'dd.user_id = u.user_id'];

        $data= $this->db->getSingleData($table, $conditions, $fields, $joins);
        // print_r($data);
        return $data;
    }
    

    // Insert user data into all three tables
    public function register($userData, $userDetailsData, $doctorDetailsData = null) {
        try {
            // Start transaction
            $this->db->beginTransaction();
            // Insert into users table
            $userId = $this->db->insertData('users', $userData); // Store the ID from the insert
    
            // Insert into user_details table
            $userDetailsData['user_id'] = $userId;
            $this->db->insertData('user_details', $userDetailsData);
    
            // If doctor details are provided, insert into doctor_details table
            if ($doctorDetailsData) {
                $doctorDetailsData['user_id'] = $userId;
                $this->db->insertData('doctor_details', $doctorDetailsData);
            }
    
            // Commit transaction
            $this->db->commit();
            return $userId;
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            $this->db->rollBack();
            error_log("Registration failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }

    // update profile picture
    public function updateProfileImage($userId, $imageName){
        try {
            return $this->db->updateData('users', ['image' => $imageName], ['user_id' => $userId]);
            
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            error_log("Profile changed failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }

    // Get all doctors
    public function getDoctors()
    {
        return $this->db->getData('users', ['role_id' => 2]); // Assuming role_id 2 is for doctors
    }

    // Get all patients
    public function getPatients()
    {
        return $this->db->getData('users', ['role_id' => 3]); // Assuming role_id 1 is for patients
    }

    public function getPatientsByDoctorId($doctorId){
        $table = 'users u';
        $conditions = ['a.doctor_id' => $doctorId]; 
        $fields = 'u.*';
        $joins = [
            'appointments a ' => 'u.user_id = a.patient_id', 
        ];
        $groupBy = "u.user_id";
        return $this->db->getData($table, $conditions, $fields, $joins, $groupBy);
    }

    public function changePassword($userId, $password){
        try {
            $data = ['password' => $password];
            $conditions = ['user_id' => $userId];

            return $this->db->updateData('users', $data, $conditions); 
            
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            error_log("Password changed failed: " . $e->getMessage()); // Log the error message
            return false;
        }
    }
    
    public function getUserById($userId){
        $table = 'users u';
        $conditions =['u.user_id' => $userId];
        $fields = 'u.*, ud.*, dd.*';
        $joins = ['user_details ud' => 'ud.user_id = u.user_id', 'doctor_details dd' => 'dd.user_id = u.user_id'];

        $data= $this->db->getSingleData($table, $conditions, $fields, $joins);
        // print_r($data);
        return $data;
        
    }


}