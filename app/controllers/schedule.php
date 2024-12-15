<?php

class schedule extends Controller{

    private $userModel;
    private $shiftModel;
    private $scheduleModel;

    public function __construct() {
        // Load the User and Role models
        $this->userModel = $this->model('Users');
        $this->shiftModel = $this->model('Shifts');
        $this->scheduleModel = $this->model('Schedules');
    }
    public function index() {
        // Get today's date and day
        $todayDate = date('Y-m-d'); // This gives the date in format YYYY-MM-DD
        $todayDay = date('l'); // This gives the full textual day, e.g., "Monday"
    
        // Fetch the schedule data
        $scheduleData = $this->scheduleModel->getScheduleWithShifts($todayDay); // Pass the current day to filter data
    
        $data = [
            'scheduleData' => $scheduleData,
            'todayDate' => $todayDate,
            'todayDay' => $todayDay,
        ];
    
        // Pass the data to the view
        $this->view('schedule/index', $data);
    }
   
    public function manage_schedule(){
        $doctors = $this->userModel->getDoctors();  // Get all doctors
        $data = [
            'doctors' => $doctors,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null,
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postData = $_POST;

            // Fetch shift IDs from the Shifts model
            $shiftMap = $this->shiftModel->getShiftIdsByTitle();

            $doctorName = trim($_POST['doctor_name']);
            $user_id = null;

            foreach ($data['doctors'] as $doctor) {
                if ($doctor['name'] === $doctorName) {
                    $user_id = $doctor['user_id'];
                    break;
                }
            }

            // Initialize schedule data
            $scheduleData = [
                'user_id' => $user_id, // Assuming doctor_id is sent as hidden input or through a data attribute
                'doctor_name' => $postData['doctor_name'],
                'sunday' => '',
                'monday' => '',
                'tuesday' => '',
                'wednesday' => '',
                'thursday' => '',
                'friday' => '',
                'saturday' => ''
            ];

            // Process shifts and populate the scheduleData
            foreach (['morning', 'evening', 'night', 'leave'] as $shiftType) {
                if (!empty($postData[$shiftType])) {
                    foreach ($postData[$shiftType] as $day) {
                        $day = strtolower(trim($day));
                        if (isset($scheduleData[$day])) {
                            // Concatenate multiple shift IDs as a comma-separated string
                            $shiftId = $shiftMap[$shiftType] ?? null;
                            if ($shiftId) {
                                $scheduleData[$day] .= ($scheduleData[$day] ? ',' : '') . $shiftId;
                            }
                        }
                    }
                }
            }

            echo '<pre>'; print_r($scheduleData); echo '</pre>'; 

            

            // Save the scheduleData in the database
            try {
                $result = $this->scheduleModel->updateSchedule($scheduleData);
                if ($result) {
                    // Set success message
                    $data['success'] = 'Schedule updated successfully.';
                } else {
                    // Set error message
                    $data['error'] = 'Schedule updation failed. Please try again.' ;
                }
            } catch (Exception $e) {
                // Log the error for debugging
                error_log($e->getMessage());
                // Set error message
                $data['error'] = 'An error occurred during registration: ' . $e->getMessage();
            }
        }


        
        $this->view('schedule/manage_schedule', $data);
    }

    

}