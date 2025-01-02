<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'med_report_management';

    public $dbh;
    private $stmt;
    private $dp;

    public function __construct() {
        // Connect to MySQL server without a specific database first
        $dsn = 'mysql:host=' . $this->host;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        

        // Try to connect to the server
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            // Create the database if it doesn't exist
            $this->createDatabase();
            
            // Reconnect with the specified database
            $this->dbh->exec('USE ' . $this->dbname);
            $this->createUsersTable();
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Function to create the database if it doesn't exist
    private function createDatabase() {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname;
            $this->dbh->exec($sql);
        } catch (PDOException $e) {
            die("Database creation failed: " . $e->getMessage());
        }
    }

    // Prepare statement with query
    public function prepare($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Prepare the SQL statement
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values to the prepared statement
    public function bindValues($values) {
        foreach ($values as $index => $value) {
            $this->stmt->bindValue($index + 1, $value);
        }
    }

    // Bind the values to the prepared statement with types
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Fetch a single record
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all records as an array of associative arrays
    public function fetchAll() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all records as an array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get the last inserted ID
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

     // Begin transaction
     public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }

    // Commit the transaction
    public function commit() {
        return $this->dbh->commit();
    }

    // Rollback the transaction
    public function rollBack() {
        return $this->dbh->rollBack();
    }

    public function createUsersTable() {
        try {
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

            'departments' => "
                CREATE TABLE IF NOT EXISTS `departments`(
                    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(255) NOT NULL UNIQUE
                );
            ",
        
            // tbl_users to store basic user details
            'users' => "
                CREATE TABLE IF NOT EXISTS `users` (
                    `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(255) NOT NULL,
                    `username` VARCHAR(255) NOT NULL UNIQUE,
                    `password` VARCHAR(255) NOT NULL,
                    `email` VARCHAR(255) NOT NULL,
                    `phone` VARCHAR(15) NOT NULL,
                    `image` VARCHAR(255) NOT NULL DEFAULT 'user.png',
                    `role_id` BIGINT UNSIGNED NOT NULL,
                    `is_active` BOOLEAN DEFAULT TRUE,
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
                    `phone` VARCHAR(15) NOT NULL,
                    `dob` DATE NOT NULL,
                    `age` INT,
                    `gender` ENUM('male', 'female', 'others') NOT NULL,
                    `blood_group` ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'unknown') NOT NULL,
                    `father_name` VARCHAR(255),
                    `mother_name` VARCHAR(255),
                    `permanent_address` VARCHAR(255),
                    `temporary_address` VARCHAR(255),
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) 
                    ON DELETE CASCADE ON UPDATE NO ACTION
                );
            ",
            'doctor_details' => "
                CREATE TABLE IF NOT EXISTS `doctor_details` (
                    `user_id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,
                    `department_id` BIGINT UNSIGNED NOT NULL,  
                    `license_number` VARCHAR(255) NOT NULL,   
                    `experience_years` INT,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`), 
                    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) 
                    ON DELETE CASCADE ON UPDATE NO ACTION
                );
            ",

            'shift' => "
                CREATE TABLE IF NOT EXISTS `shifts` (
                    `shift_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `title` VARCHAR(50) NOT NULL,
                    `start_time` TIME NOT NULL,
                    `end_time` TIME NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );

                INSERT INTO `shifts` (`title`, `start_time`, `end_time`)
                SELECT 'Morning', '07:00:00', '15:00:00'
                WHERE NOT EXISTS (SELECT 1 FROM `shifts`)
                UNION ALL
                SELECT 'Evening', '15:00:00', '23:00:00'
                WHERE NOT EXISTS (SELECT 1 FROM `shifts`)
                UNION ALL
                SELECT 'Night', '23:00:00', '07:00:00'
                WHERE NOT EXISTS (SELECT 1 FROM `shifts`)
                UNION ALL
                SELECT 'Leave', 'NULL', 'NULL'
                WHERE NOT EXISTS (SELECT 1 FROM `shifts`);
            ",

            'doctor_schedule' => "
                CREATE TABLE IF NOT EXISTS doctor_schedule (
                    `user_id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,
                    `doctor_name` VARCHAR(255) NOT NULL,
                    `sunday` VARCHAR(255), 
                    `monday` VARCHAR(255), 
                    `tuesday` VARCHAR(255),  
                    `wednesday` VARCHAR(255),
                    `thursday` VARCHAR(255),
                    `friday` VARCHAR(255),
                    `saturday` VARCHAR(255),
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) 
                    ON DELETE CASCADE ON UPDATE NO ACTION
                );
            ",

            'appointments' => "
                CREATE TABLE IF NOT EXISTS appointments (
                    `appointment_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `date` DATE NOT NULL,
                    `time` TIME NOT NULL,
                    `patient_id` BIGINT UNSIGNED,
                    `patient_name` VARCHAR(25) NOT NULL,    
                    `age` INT NOT NULL,
                    `phone` VARCHAR(15) NOT NULL,
                    `symptoms` TEXT,
                    `department_id` BIGINT UNSIGNED NOT NULL,
                    `doctor_id` BIGINT UNSIGNED NOT NULL,
                    `status` BOOLEAN DEFAULT FALSE,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (patient_id) REFERENCES users(`user_id`),
                    FOREIGN KEY (doctor_id) REFERENCES users(`user_id`),
                    FOREIGN KEY (department_id) REFERENCES departments(`id`)
                );
            ",
            'prescriptions' => "
                CREATE TABLE IF NOT EXISTS prescriptions (
                    `prescription_id` INT AUTO_INCREMENT PRIMARY KEY,
                    `appointment_id` INT NOT NULL,
                    `examination_detail` TEXT,
                    `disease` VARCHAR(255),
                    `medicine_name` VARCHAR(255) NOT NULL,
                    `instructions` TEXT,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id)
                );
            ",
            'notifications' => "
                CREATE TABLE IF NOT EXISTS notifications (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id BIGINT UNSIGNED NOT NULL,
                    message TEXT NOT NULL,
                    is_read BOOLEAN DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
                );
            "

        ];

        foreach ($sql as $table => $createQuery) {
            try {
                // Execute the create table query
                $this->dbh->exec($createQuery);
                // $this->dbh->query($createQuery);
                // $this->execute(); 
                // $this->db->exec($createQuery);
            } catch (PDOException $e) {
                echo "Error creating table '$table': " . $e->getMessage() . "<br>";
            }
        }

        // $this->dp->insertDepartment();

        // Execute the table creation query
        // $this->db->query($sql);
        // $this->db->execute();  // Execute the query to create the table

        // Hash the password
        $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

        // Prepare the SQL insert query
        $sqlInsert = "
            INSERT INTO users (username, password, name, email, phone, role_id, is_active)
            SELECT :username, :password, :name, :email, :phone, :role_id, :is_active
            FROM DUAL
            WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = :username);
        ";

        // Prepare the statement
        $this->prepare($sqlInsert);

        // Bind the values
        $this->bind(':username', 'admin_01');
        $this->bind(':password', $hashed_password);
        $this->bind(':name', 'Admin');
        $this->bind(':email', 'admin@example.com');
        $this->bind(':phone', '9742487088');
        $this->bind(':role_id', 1);
        $this->bind(':is_active', true);

        // Execute the statement
        $this->execute();
        } catch (PDOException $e) {
            die("Table creation failed: " . $e->getMessage());
        }
    }


}
