<?php
// class Departments{
//     private $db;
//     public function __construct() {
//         $this->db = new Sql();
//         $this->auth_route = new AuthRoute();
//     }
    
//     public function insertDepartment(){
//         $departments = include __DIR__ . '/../helpers/Departments.php';
//         foreach ($departments as $department) {
//             if (!empty($department)) {
//                 $departmentData = [
//                     // 'prescription_id' => $prescriptionId,
//                     'id' => $department['department_id'],
//                     'name' => $department['department_name'],
//                 ];
//                 try {
//                     $result = $this->db->insertData('departments', $departmentData);
    
//                     if (!$result) {
//                         error_log("Failed to insert department: ");
//                     }
//                 } catch (Exception $e) {
//                     error_log("Error inserting department: " . $e->getMessage());
//                 }
//             }
//         }
//     }
    

//     public function getDepartments(){
//         return $this->db->getData('departments');
//     }
    
   
    

// }


class Departments {
    private $db;
    private $sql;

    public function __construct() {
        $this->db = new Database();
        $this->sql = new Sql();
        $this->auth_route = new AuthRoute();

    }

    public function insertDepartment() {
        $departments = include __DIR__ . '/../helpers/Departments.php';

        foreach ($departments as $department) {
            $sql = "INSERT INTO `departments` (`id`, `name`)
                    SELECT :id, :name
                    WHERE NOT EXISTS (SELECT 1 FROM `departments` WHERE `id` = :id)";
            $stmt = $this->db->dbh->prepare($sql);
            $stmt->execute([
                ':id' => $department['department_id'],
                ':name' => $department['department_name']
            ]);
        }
    }

    public function getDepartments() {
        $this->db->query("SELECT * FROM `departments`");
        return $this->db->fetchAll();
    }

    public function getDoctorByDepartment($departmentId){
        $table = 'doctor_details dd';
        $conditions = [ 'dd.department_id' => $departmentId]; // No specific conditions for the table
        $fields = 'dd.user_id, dd.department_id, dept.name AS department_name, u.name AS doctor_name';
        
        $joins = [
            'departments dept' => 'dd.department_id = dept.id','users u' => 'dd.user_id = u.user_id', 
        ];
        
        // Fetch the data
        return $this->sql->getData($table, $conditions, $fields, $joins);
    }
}
