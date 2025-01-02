<?php

use App\Helpers\PdfGenerator;

class GeneratePdf extends BaseController
{
    private $appointmentModel;
    private $prescriptionModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        // Load the User and Role models
        $this->appointmentModel = $this->model('Appointments');
        $this->prescriptionModel = $this->model('Prescriptions');
        $this->userModel = $this->model('Users');
    }
    public function generatePatientReport()
    {
        $appointmentId = $_GET['app_id'];
        $prescriptions = $this->prescriptionModel->getPrescriptionByAppointmentId($appointmentId);
        // Fetch data (replace with actual data fetching logic)
        $data =[
            'prescriptions' => $prescriptions
        ];

        // Get the absolute path of the logo image
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/logo_green.png';

        // Convert the image to Base64 encoding
        $imageData = base64_encode(file_get_contents($imagePath));

        // Prepare the Base64 image source for embedding in the HTML
        $base64Image = 'data:image/png;base64,' . $imageData;

        // Start output buffering
        ob_start();
        ?>
        <html>
        <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                font-size: 12px;
                color: #333;
            }
            p{
                font-size: 15px;
            }
            /* Header Section */
            .hospitalDetails {
                width: 100%;
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 2px solid #ddd;
            }
            .hospitalInfo {
                width: 70%;
                display: inline-block;
                vertical-align: top;
            }

            .hospitalInfo img {
                width: 60px;
                height: 60px;
                float: left;
                margin-right: 10px;
            }

            .hospitalName {
                font-size: 24px;
                font-weight: bold;
                color: #4caf50; /* Green color for the hospital name */
                margin: 0;
            }

            .address {
                font-size: 12px;
                color: #555;
                margin: 0;
            }

            .hospitalContact {
                width: 90%;
                display: inline-block;
                text-align: right;
                font-size: 12px;
            }

            .hospitalContact p {
                margin: 0;
            }

            /* Patient Details Section */
            .title{
                font-size: 22px;
                font-weight: 600;
                margin: 0;
            }
            .patientDetail , .diagnosisDetail{
                width: 100%;
                border-bottom: 2px solid #ddd;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .patientImage img {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 50%;
            }

           
           

            /* Table Styling (if any) */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: -10px;
            }

            table th{
                padding: 8px;
                text-align: left;
                font-size: 17px;
            }

            table th {
                background-color: #f4f4f4;
                font-weight: bold;
            }
        </style>


        </head>
        <body>
            <div class="hospitalDetails">
                <div class="hospitalInfo">
                    <div class="logo">
                        <img src="<?= $base64Image ?>" alt="">
                    </div>
                    <div>
                        <p class="hospitalName">Family Hospital</p>
                        <p class="address">BudhanilKantha-10, Kathmandu</p>
                    </div>
                </div>
                <div class="hospitalContact">
                    <p class="contact">Ph: 9742487088</p>
                    <p class="email">Email: familyhospital@gmail.com</p>
                </div>
            </div>
            <?php 
                $currentAppointmentId = null;
                foreach ($data['prescriptions'] as $index => $prescription): 
            ?>
                <?php if ($currentAppointmentId !== $prescription['appointment_id']): ?>
                    <?php $currentAppointmentId = $prescription['appointment_id']; ?>
        
                        <div class="records">
                            <div class="expandedDetailBackground">
                                <div class="patientDetail">
                                    <p class="title">Patient Info:</p>
                                    <table>
                                        <tr>
                                            <!-- Left Column -->
                                            <td style="width: 15%;">
                                                <p><strong>Patient Id</strong></p>
                                                <p><strong>Name</strong> </p>
                                                <p><strong>Gender</strong></p>
                                                <p><strong>Age</strong></p> 
                                            </td>
                                            <td style="width: 35%;">
                                                <p>: <?= htmlspecialchars($prescription['patient_id']); ?></p>
                                                <p>: <?= htmlspecialchars($prescription['patient_name']); ?></p>
                                                <p>: <?= htmlspecialchars($prescription['gender']); ?></p>
                                                <p>: <?= htmlspecialchars($prescription['age']); ?></p>
                                            </td>
                                            <!-- Right Column -->
                                            <td style="width: 20%;">
                                                <p><strong>Blood Group</strong> </p>
                                                <p><strong>Phone</strong> </p>
                                                <p><strong>Email</strong> </p>
                                                <p><strong>Address</strong></p>
                                            </td>
                                            <td style="width: 35%;">
                                                <p>: <?= htmlspecialchars($prescription['blood_group']); ?></p>
                                                <p>: <?= htmlspecialchars($prescription['phone']); ?></p>
                                                <p>: <?= htmlspecialchars($prescription['patient_email']); ?></p>
                                                <p>: <?= htmlspecialchars($prescription['permanent_address']); ?></p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="diagnosisDetail">
                                    <p class="title">Diagnosis</p>
                                    <table>
                                        <tr>
                                            <td style="width: 20%;">
                                                <p><strong>Diagnosed By</strong></p>
                                                <p><strong>Category</strong></p>
                                                <p><strong>Phone</strong></p>
                                            </td>
                                            <td style="width: 50%;">
                                                <p>: <?= htmlspecialchars($prescription['doctor_name']); ?> </p>
                                                <p>: <?= htmlspecialchars($prescription['department_name']); ?> </p>
                                                <p>: <?= htmlspecialchars($prescription['doctor_phone']); ?> </p>
                                            </td>
                                            <td style="width: 10%;">
                                                <p><strong>Date</strong></p>
                                            </td>
                                            <td style="width: 20%;">
                                                <p>:  <?= htmlspecialchars($prescription['date']); ?></p>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                    <div class="examinationDetail">
                                        <p class="title">Disease</p>
                                    <p><?= htmlspecialchars($prescription['disease']); ?> </p>
                                    </div>
                                    <div class="examinationDetail">
                                    <p class="title">Examination </p>
                                    <p><?= htmlspecialchars($prescription['examination_detail']); ?> </p>
                                    </div>
                                    <div class="prescription">
                                        <p class="title">Prescriptions</p>
                                            <table>
                                                <tr>
                                                    <th width="30%">Medicine</th>
                                                    <th width="65%">Instruction</th>
                                                </tr>
                                            </table>
                                            
                                        <?php endif; ?>
                                        <table>
                                            <tr>
                                                <td width="30%"><p><?= htmlspecialchars($prescription['medicine_name']); ?></p></td>
                                                <td width="65%"><p><?= htmlspecialchars($prescription['instructions']); ?></p></td>
                                            </tr>
                                        </table>
                                        <?php 
                                            // Check if the next item has a different appointment_id or if it is the last item
                                            if (!isset($data['prescriptions'][$index + 1]) || $data['prescriptions'][$index + 1]['appointment_id'] !== $currentAppointmentId): 
                                        ?>
                                    </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </body>
        </html>
        <?php

        // Get the HTML content
        $htmlContent = ob_get_clean();

        $fileName = 'patient_report_' . $appointmentId . '.pdf';

        // Generate the PDF and download it
        PdfGenerator::generate($htmlContent, $fileName);
    }
}
