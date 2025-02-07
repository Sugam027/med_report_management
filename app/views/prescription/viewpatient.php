<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading titleHead">
        <p class="headingName">Patient Info</p>
        <div class="button-group">
            <a href="/prescription"><p class="btn">Back</p></a>
        </div>
    </div>
    <div class="profileCardBackground">
        <div class="row">
            <div class="col-md-4">
                <div class="profileCard">
                    <div class="profileCardImage">
                        <img src="/uploads/profile_images/<?= $data['patients']['image'] ?>" alt="" width="100%" height="100%">
                    </div>
                    <div class="profileCardName"><?= $data['patients']['name'] ?></div>
                    <div class="profileCardAge">Age: <?= $data['patients']['age'] ?></div>
                </div>
                <div class="profileInfo">
                    <p class="profileCardTitle">Information</p>
                    <div class="profileInfoList">
                        <p class="field">Gender:</p>
                        <p class="value"><?= $data['patients']['gender'] ?></p>
                    </div>
                    <div class="profileInfoList">
                        <p class="field">Blood Type:</p>
                        <p class="value"><?= $data['patients']['blood_group'] ?></p>
                    </div>
                    <div class="profileInfoList">
                        <p class="field">User Id:</p>
                        <p class="value"><?= $data['patients']['user_id'] ?></p>
                    </div>
                    <div class="profileInfoList">
                        <p class="field">Phone:</p>
                        <p class="value"><?= $data['patients']['phone'] ?></p>
                    </div>
                    <div class="profileInfoList">
                        <p class="field">DoB:</p>
                        <p class="value"><?= $data['patients']['dob'] ?></p>
                    </div>
                    <div class="profileInfoList">
                        <p class="field">Address:</p>
                        <p class="value"><?= $data['patients']['permanent_address'] ?></p>
                    </div>

                </div>
            </div>
            <div class="col-md-8">
                <div class="prescriptionCard">
                <p class="profileCardTitle">Prescriptions</p>
                <?php if (!empty($data['prescriptions'])): ?>
        <?php 
        $currentAppointmentId = null;
        foreach ($data['prescriptions'] as $index => $prescription): 
        ?>
        <?php if ($currentAppointmentId !== $prescription['appointment_id']): ?>
            <?php $currentAppointmentId = $prescription['appointment_id']; ?>
            <div class="records">
            <div class="date">
                <p class="day" id="day"><?= htmlspecialchars($prescription['date']); ?></p>
            </div>
            <div class="cardBody">
                
                
                <div class="cardInfo">
                    <?php if(!empty($prescription['disease'])): ?>
                    <div class="examination mb-2">
                        <p class="examinationTitle">Diseases</p>
                        <p class="examinationDetails"><?= htmlspecialchars($prescription['disease']); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($prescription['symptoms'])): ?>
                    <div class="examination mb-2">
                        <p class="examinationTitle">Symptoms</p>
                        <p class="examinationDetails"><?= htmlspecialchars($prescription['symptoms']); ?></p>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <?php if(!empty($prescription['test'])): ?>
                        <div class="examination mb-2">
                            <p class="examinationTitle">Symptoms</p>
                            <p class="examinationDetails"><?= htmlspecialchars($prescription['symptoms']); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($prescription['blood_pressure'])): ?>
                        <div class="examination mb-2">
                            <p class="examinationTitle">Blood Pressure</p>
                            <p class="examinationDetails"><?= htmlspecialchars($prescription['blood_pressure']); ?> mmHG</p>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($prescription['temperature'])): ?>
                        <div class="examination mb-2">
                            <p class="examinationTitle">Temperature</p>
                            <p class="examinationDetails"><?= htmlspecialchars($prescription['temperature']); ?>&deg;F</p>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($prescription['heart_rate'])): ?>
                        <div class="examination mb-2">
                            <p class="examinationTitle">Heart Rate</p>
                            <p class="examinationDetails"><?= htmlspecialchars($prescription['heart_rate']); ?> bpm</p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($prescription['heart_rate'])): ?>
                    <div class="examination mb-2">
                        <p class="examinationTitle">Test</p>    
                        <ul>
                        <?php 
                            $test_names = explode(', ', $prescription['test_names']); 
                            $test_results = explode(', ', $prescription['test_results']);
                            $test_files = explode(', ', $prescription['test_files']);

                            for ($i = 0; $i < count($test_names); $i++): 
                        ?>
                            <li class="medicineItem">
                                <strong>Name:</strong> <span><?= htmlspecialchars($test_names[$i]); ?></span>
                                <strong>Result:</strong> <span><?= htmlspecialchars($test_results[$i] ?? ''); ?></span>
                                <?php if (!empty($test_files[$i])): ?>
                                <a href="/uploads/test_results/<?= urlencode($test_files[$i]); ?>" target="_blank">
                                    <button class="viewImageButton">View File</button>
                                </a>
                            <?php endif; ?>
                            </li>
                        <?php endfor; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <div class="examination mb-2">
                        <p class="examinationTitle">Examination</p>
                        <p class="examinationDetails"><?= htmlspecialchars($prescription['examination_detail']); ?></p>
                    </div>
                    <div class="prescription mb-2">
                    <p class="prescriptionTitle">Prescription</p>
                    <ul class="prescriptionList">
                    <?php endif; ?>
                        
                        <?php 
                            $medicines = explode(', ', $prescription['medicine_names']); 
                            $instructions = explode(', ', $prescription['medicine_instructions']);

                            for ($i = 0; $i < count($medicines); $i++): 
                        ?>
                            <li class="medicineItem">
                                <strong>Medicine:</strong> <span><?= htmlspecialchars($medicines[$i]); ?></span>
                                <strong>Instructions:</strong> <span><?= htmlspecialchars($instructions[$i] ?? ''); ?></span>
                            </li>
                        <?php endfor; ?>
                        <?php 
                            // Check if the next item has a different appointment_id or if it is the last item
                            if (!isset($data['prescriptions'][$index + 1]) || $data['prescriptions'][$index + 1]['appointment_id'] !== $currentAppointmentId): 
                        ?>
                    </ul>
                    </div>
                </div>
                <div class="generate-pdf">
                    <button onclick="window.open('/generatepdf/generatePatientReport?app_id=<?= $prescription['appointment_id'] ?>', '_blank')">Generate PDF</button>
                </div>
            </div>
            </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php else: ?>
            <p>No data</p>
        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</main>



<?php require_once '../app/views/templates/footer.php'; ?>
