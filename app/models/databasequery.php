<?php

// class DatabaseQuery {
//     private $db;
//     private $dp;

//     public function __construct() {
//         $this->db = new Database();
//         $this->dp = new Departments();
//     }

//     // Method to handle the table creation
//     public function createUsersTable() {

//         $sql = [
//             'roles' => "
//                 CREATE TABLE IF NOT EXISTS `roles` (
//                     `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                     `title` VARCHAR(255) NOT NULL UNIQUE,
//                     `permissions` INT DEFAULT 3,
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//                 );
                
//                 INSERT INTO `roles` (`title`, `permissions`)
//                 SELECT 'Admin', 1
//                 WHERE NOT EXISTS (SELECT 1 FROM `roles`)
//                 UNION ALL
//                 SELECT 'Doctor', 2
//                 WHERE NOT EXISTS (SELECT 1 FROM `roles`)
//                 UNION ALL
//                 SELECT 'Patient', 3
//                 WHERE NOT EXISTS (SELECT 1 FROM `roles`);
//             ",

//             'departments' => "
//                 CREATE TABLE IF NOT EXISTS `departments`(
//                     `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                     `name` VARCHAR(255) NOT NULL UNIQUE
//                 );
//             ",
        
//             // tbl_users to store basic user details
//             'users' => "
//                 CREATE TABLE IF NOT EXISTS `users` (
//                     `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
//                     `name` VARCHAR(255) NOT NULL,
//                     `username` VARCHAR(255) NOT NULL UNIQUE,
//                     `password` VARCHAR(255) NOT NULL,
//                     `email` VARCHAR(255) NOT NULL,
//                     `phone` VARCHAR(15) NOT NULL,
//                     `image` VARCHAR(15) NOT NULL DEFAULT 'user.png',
//                     `role_id` BIGINT UNSIGNED NOT NULL,
//                     `is_active` BOOLEAN DEFAULT TRUE,
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//                     FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) 
//                     ON DELETE NO ACTION ON UPDATE NO ACTION
//                 )AUTO_INCREMENT=1000;
//             ",
        
            
//             'user_details' => "
//                 CREATE TABLE IF NOT EXISTS `user_details` (
//                     `user_id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,
//                     `full_name` VARCHAR(255) NOT NULL,
//                     `phone` VARCHAR(15) NOT NULL,
//                     `dob` DATE NOT NULL,
//                     `age` INT,
//                     `gender` ENUM('male', 'female', 'others') NOT NULL,
//                     `blood_group` ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'unknown') NOT NULL,
//                     `father_name` VARCHAR(255),
//                     `mother_name` VARCHAR(255),
//                     `permanent_address` VARCHAR(255),
//                     `temporary_address` VARCHAR(255),
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//                     FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) 
//                     ON DELETE CASCADE ON UPDATE NO ACTION
//                 );
//             ",
//             'doctor_details' => "
//                 CREATE TABLE IF NOT EXISTS `doctor_details` (
//                     `user_id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,
//                     `department_id` VARCHAR(255) NOT NULL,  
//                     `license_number` VARCHAR(255) NOT NULL,   
//                     `experience_years` INT,
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//                     FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) 
//                     FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) 
//                     ON DELETE CASCADE ON UPDATE NO ACTION
//                 );
//             ",

//             'shift' => "
//                 CREATE TABLE IF NOT EXISTS `shifts` (
//                     `shift_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `title` VARCHAR(50) NOT NULL,
//                     `start_time` TIME NOT NULL,
//                     `end_time` TIME NOT NULL,
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//                 );

//                 INSERT INTO `shifts` (`title`, `start_time`, `end_time`)
//                 SELECT 'Morning', '07:00:00', '15:00:00'
//                 WHERE NOT EXISTS (SELECT 1 FROM `shifts`)
//                 UNION ALL
//                 SELECT 'Evening', '15:00:00', '23:00:00'
//                 WHERE NOT EXISTS (SELECT 1 FROM `shifts`)
//                 UNION ALL
//                 SELECT 'Night', '23:00:00', '07:00:00'
//                 WHERE NOT EXISTS (SELECT 1 FROM `shifts`)
//                 UNION ALL
//                 SELECT 'Leave', 'NULL', 'NULL'
//                 WHERE NOT EXISTS (SELECT 1 FROM `shifts`);
//             ",

//             'doctor_schedule' => "
//                 CREATE TABLE IF NOT EXISTS doctor_schedule (
//                     `user_id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,
//                     `doctor_name` VARCHAR(255) NOT NULL,
//                     `sunday` VARCHAR(255), 
//                     `monday` VARCHAR(255), 
//                     `tuesday` VARCHAR(255),  
//                     `wednesday` VARCHAR(255),
//                     `thursday` VARCHAR(255),
//                     `friday` VARCHAR(255),
//                     `saturday` VARCHAR(255),
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//                     FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) 
//                     ON DELETE CASCADE ON UPDATE NO ACTION
//                 );
//             ",

//             'appointments' => "
//                 CREATE TABLE IF NOT EXISTS appointments (
//                     `appointment_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `date` DATE NOT NULL,
//                     `time` TIME NOT NULL,
//                     `patient_id` BIGINT UNSIGNED,
//                     `patient_name` VARCHAR(25) NOT NULL,    
//                     `age` INT NOT NULL,
//                     `phone` VARCHAR(15) NOT NULL,
//                     `symptoms` TEXT,
//                     `department_ID` INT,
//                     `doctor_id` BIGINT UNSIGNED NOT NULL,
//                     `status` BOOLEAN DEFAULT FALSE,
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//                     FOREIGN KEY (patient_id) REFERENCES users(`user_id`),
//                     FOREIGN KEY (doctor_id) REFERENCES users(`user_id`)
//                     FOREIGN KEY (department_id) REFERENCES departments(`id`)
//                 );
//             ",
//             'prescriptions' => "
//                 CREATE TABLE IF NOT EXISTS prescriptions (
//                     `prescription_id` INT AUTO_INCREMENT PRIMARY KEY,
//                     `appointment_id` INT NOT NULL,
//                     `examination_detail` TEXT,
//                     `disease` VARCHAR(255),
//                     `medicine_name` VARCHAR(255) NOT NULL,
//                     `instructions` TEXT,
//                     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//                     `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//                     FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id)
//                 );
//             "

//         ];

//         foreach ($sql as $table => $createQuery) {
//             try {
//                 // Execute the create table query
//                 $this->db->query($createQuery);
//                 $this->db->execute(); 
//                 // $this->db->exec($createQuery);
//             } catch (PDOException $e) {
//                 echo "Error creating table '$table': " . $e->getMessage() . "<br>";
//             }
//         }

//         $this->dp->insertDepartment();

//         // Execute the table creation query
//         // $this->db->query($sql);
//         // $this->db->execute();  // Execute the query to create the table

//         // Hash the password
//         $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

//         // Prepare the SQL insert query
//         $sqlInsert = "
//             INSERT INTO users (username, password, name, email, phone, role_id, is_active)
//             SELECT :username, :password, :name, :email, :phone, :role_id, :is_active
//             FROM DUAL
//             WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = :username);
//         ";

//         // Prepare the statement
//         $this->db->prepare($sqlInsert);

//         // Bind the values
//         $this->db->bind(':username', 'admin_01');
//         $this->db->bind(':password', $hashed_password);
//         $this->db->bind(':name', 'Admin');
//         $this->db->bind(':email', 'admin@example.com');
//         $this->db->bind(':phone', '9742487088');
//         $this->db->bind(':role_id', 1);
//         $this->db->bind(':is_active', true);

//         // Execute the insert query
//         $this->db->execute();
//     }

//     // public function insertDepartment(){
//     //     $departments = include __DIR__ . '/../helpers/Departments.php';
//     //     print_r($departments);
//     //     foreach ($departments as $department) {
//     //         if (!empty($department)) {
//     //             $departmentData = [
//     //                 // 'prescription_id' => $prescriptionId,
//     //                 'id' => $department['department_id'],
//     //                 'name' => $department['department_name'],
//     //             ];
//     //             try {
//     //                 $result = $this->sq->insertData('departments', $departmentData);
    
//     //                 if (!$result) {
//     //                     error_log("Failed to insert department: ");
//     //                 }
//     //             } catch (Exception $e) {
//     //                 error_log("Error inserting department: " . $e->getMessage());
//     //             }
//     //             // $this->sql->add($prescriptionData);
//     //         }
//     //     }
//     // }

// }
