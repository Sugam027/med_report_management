<?php

class DatabaseQuery {
    private $db;

    public function __construct() {
        // Instantiate the Database class
        $this->db = new Database();
    }

    // Method to handle the table creation
    public function createUsersTable() {
        // Create the user table
        // $sql = "
        //     CREATE TABLE IF NOT EXISTS user (
        //         userId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        //         username VARCHAR(30) NOT NULL,
        //         password VARCHAR(255) NOT NULL,
        //         name VARCHAR(30) NOT NULL,
        //         email VARCHAR(50),
        //         role ENUM('admin', 'superadmin', 'patient', 'doctor') NOT NULL,
        //         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        //         UNIQUE(userId)
        //     ) AUTO_INCREMENT=1000;
        // ";

        $sql = [
            'roles' => "
                CREATE TABLE IF NOT EXISTS `roles` (
                    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `title` VARCHAR(255) NOT NULL UNIQUE,
                    `permissions` INT DEFAULT 3,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
                
                INSERT INTO `roles` (`title`, `permissions`)
                SELECT 'Admin', 1
                WHERE NOT EXISTS (SELECT 1 FROM `roles`)
                UNION ALL
                SELECT 'Doctor', 2
                WHERE NOT EXISTS (SELECT 1 FROM `roles`)
                UNION ALL
                SELECT 'Patient', 3
                WHERE NOT EXISTS (SELECT 1 FROM `roles`);
            ",
        
            // tbl_users to store basic user details
            'users' => "
                CREATE TABLE IF NOT EXISTS `users` (
                    `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `username` VARCHAR(255) NOT NULL UNIQUE,
                    `password` VARCHAR(255) NOT NULL,
                    `email` VARCHAR(255) NOT NULL UNIQUE,
                    `name` VARCHAR(255) NOT NULL,
                    `role_id` BIGINT UNSIGNED NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) 
                    ON DELETE NO ACTION ON UPDATE NO ACTION
                )AUTO_INCREMENT=1000;
            ",
        
            
            'user_details' => "
                CREATE TABLE IF NOT EXISTS `user_details` (
                    `user_id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,
                    `full_name` VARCHAR(255) NOT NULL,
                    `phone_no` VARCHAR(15) NOT NULL,
                    `dob` DATE NOT NULL,
                    `age` INT,
                    `gender` ENUM('male', 'female', 'others') NOT NULL,
                    `blood_group` ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'unknown') NOT NULL,
                    `father_name` VARCHAR(255),
                    `mother_name` VARCHAR(255),
                    `department` VARCHAR(255),
                    `permanent_province` VARCHAR(255),
                    `permanent_district` VARCHAR(255),
                    `permanent_municipality` VARCHAR(255),
                    `permanent_ward_no` INT,
                    `permanent_tole` VARCHAR(255),
                    `temporary_province` VARCHAR(255),
                    `temporary_district` VARCHAR(255),
                    `temporary_municipality` VARCHAR(255),
                    `temporary_ward_no` INT,
                    `temporary_tole` VARCHAR(255),
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) 
                    ON DELETE CASCADE ON UPDATE NO ACTION
                );
            "
        ];

        foreach ($sql as $table => $createQuery) {
            try {
                // Execute the create table query
                $this->db->query($createQuery);
                $this->db->execute(); 
                // $this->db->exec($createQuery);
            } catch (PDOException $e) {
                echo "Error creating table '$table': " . $e->getMessage() . "<br>";
            }
        }
        

        // Execute the table creation query
        // $this->db->query($sql);
        // $this->db->execute();  // Execute the query to create the table

        // Hash the password
        $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

        // Prepare the SQL insert query
        $sqlInsert = "
            INSERT INTO users (username, password, name, email, role_id)
            SELECT :username, :password, :name, :email, :role_id
            FROM DUAL
            WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = :username);
        ";

        // Prepare the statement
        $this->db->prepare($sqlInsert);

        // Bind the values
        $this->db->bind(':username', 'admin_01');
        $this->db->bind(':password', $hashed_password);
        $this->db->bind(':name', 'Admin');
        $this->db->bind(':email', 'admin@example.com');
        $this->db->bind(':role_id', 1);

        // Execute the insert query
        $this->db->execute();
    }
}
