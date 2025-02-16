<?php

class schedule extends BaseController{

    private $userModel;
    private $shiftModel;
    private $scheduleModel;

    public function __construct() {
        parent::__construct();
        // Load the User and Role models
        $this->userModel = $this->model('Users');
        $this->shiftModel = $this->model('Shifts');
        $this->scheduleModel = $this->model('Schedules');
    }
    public function index() {
        date_default_timezone_set('Asia/Kathmandu'); 
        // Get today's date and day
        $todayDate = date('Y-m-d'); // This gives the date in format YYYY-MM-DD
        $todayDay = date('l'); // This gives the full textual day, e.g., "Monday"
        $todayTime = date('H:i:s'); 
    
        // Fetch the schedule data
        $scheduleData = $this->scheduleModel->getScheduleWithShifts($todayDay, $todayTime); // Pass the current day to filter data
        $userRoleId = $_SESSION['role_id'];
        $userId = $_SESSION['user_id'];
        if($userRoleId == 2){
        $scheduleData = $this->scheduleModel->getScheduleById($userId); 

        }
    
        $data = [
            'scheduleData' => $scheduleData,
            'todayDate' => $todayDate,
            'todayDay' => $todayDay,
            'todayTime' => $todayTime,
        ];
        // Pass the data to the view
        $this->view('schedule/index', $data);
    }
   
    // public function manage_schedule(){
    //     $doctors = $this->userModel->getDoctors();  // Get all doctors
    //     $data = [
    //         'doctors' => $doctors
    //     ];

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $postData = $_POST;

    //         // Fetch shift IDs from the Shifts model
    //         $shiftMap = $this->shiftModel->getShiftIdsByTitle();

    //         $doctorName = trim($_POST['doctor_name']);
    //         $user_id = null;

    //         foreach ($data['doctors'] as $doctor) {
    //             if ($doctor['name'] === $doctorName) {
    //                 $user_id = $doctor['user_id'];
    //                 break;
    //             }
    //         }

    //         // Initialize schedule data
    //         $scheduleData = [
    //             'user_id' => $user_id, // Assuming doctor_id is sent as hidden input or through a data attribute
    //             'doctor_name' => $postData['doctor_name'],
    //             'sunday' => '',
    //             'monday' => '',
    //             'tuesday' => '',
    //             'wednesday' => '',
    //             'thursday' => '',
    //             'friday' => '',
    //             'saturday' => ''
    //         ];

    //         // Process shifts and populate the scheduleData
    //         foreach (['morning', 'evening', 'night', 'leave'] as $shiftType) {
    //             if (!empty($postData[$shiftType])) {
    //                 foreach ($postData[$shiftType] as $day) {
    //                     $day = strtolower(trim($day));
    //                     if (isset($scheduleData[$day])) {
    //                         $shiftId = $shiftMap[$shiftType] ?? null;
    //                         if ($shiftId) {
    //                             // Append shift ID to the respective day
    //                             $scheduleData[$day] .= ($scheduleData[$day] ? ',' : '') . $shiftId;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         // Save the scheduleData in the database
    //         try {
    //             $result = $this->scheduleModel->updateSchedule($scheduleData);
    //             print_r($result);
    //             if($result) {
    //                 // Set success message
    //                 $this->auth_route->setSessionMessage(true, 'Schedule updated successfully.');
    //             } else {
    //                 $this->auth_route->setSessionMessage(false, 'Schedule updation failed. Please try again.');
    //             }
    //         } catch (Exception $e) {
    //             echo error_log("Error in manage_schedule: " . $e->getMessage());
    //             $this->auth_route->setSessionMessage(false, 'Schedule updation failed. Please try again.');
    //         }
    //     }


        
    //     $this->view('schedule/manage_schedule', $data);
    // }

    public function manage_schedule(){
        $this->auth_route->checkPermission([1]);
        $doctors = $this->userModel->getDoctors();  // Get all doctors
    
        $data = [
            'doctors' => $doctors
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postData = $_POST;
            $userId = trim($_POST['user_id']);  // Get the selected doctor ID
            $doctor_name = null;
            
            // Fetch shift IDs from the Shifts model
            $shiftMap = $this->shiftModel->getShiftIdsByTitle();
            
            foreach ($data['doctors'] as $doctor) {
                // Ensure both are of the same type before comparison
                if ((string) $doctor['user_id'] === (string) $userId) {
                    $doctor_name = $doctor['name'];
                    break;
                }
            }
    
            // Initialize schedule data with empty shifts
            $scheduleData = [
                'user_id' => $userId,
                'doctor_name' => $doctor_name,
                'sunday' => '',
                'monday' => '',
                'tuesday' => '',
                'wednesday' => '',
                'thursday' => '',
                'friday' => '',
                'saturday' => ''
            ];
    
            // Process shifts (morning, evening, night, leave) and populate the scheduleData
            foreach (['morning', 'evening', 'night', 'leave'] as $shiftType) {
                if (!empty($postData[$shiftType])) {
                    foreach ($postData[$shiftType] as $day) {
                        $day = strtolower(trim($day));
                        if (isset($scheduleData[$day])) {
                            $shiftId = $shiftMap[$shiftType] ?? null;
                            if ($shiftId) {
                                // Append shift ID to the respective day
                                $scheduleData[$day] .= ($scheduleData[$day] ? ',' : '') . $shiftId;
                            }
                        }
                    }
                }
            }

            // print_r($scheduleData);
    
            // Check if a schedule already exists for the doctor (for update)
            $existSchedules = $this->scheduleModel->getDoctorSchedule($userId);
            
            try {
                if ($existSchedules) {
                    // Update existing schedule
                    $result = $this->scheduleModel->updateSchedule($scheduleData, $userId);
                    $message = $result ? 'Schedule updated successfully.' : 'Schedule updation failed. Please try again.';
                } else {
                    // Insert new schedule
                    $result = $this->scheduleModel->insertSchedule($scheduleData);
                    $message = $result ? 'Schedule added successfully.' : 'Schedule insertion failed. Please try again.';
                }
                
                // Set session message for success or failure
                $this->auth_route->setSessionMessage($result, $message);
            } catch (Exception $e) {
                error_log("Error in update schedule: " . $e->getMessage());
                $this->auth_route->setSessionMessage(false, 'Schedule operation failed. Please try again.');
            }
        }
    
        
    
        $this->view('schedule/manage_schedule', $data);
    }

    public function getDoctorSchedule($doctorId){
        $schedule = $this->scheduleModel->getDoctorSchedule($doctorId);
        if ($schedule && $schedule['user_id'] == $doctorId) {
            // Send only the schedule for the selected doctor
            echo json_encode($schedule);
        } else {
            // If no match, return an empty object
            echo json_encode([]);
        }

    }
    

    

}