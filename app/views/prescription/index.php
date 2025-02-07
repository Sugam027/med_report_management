<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <?php $role = Session::get('role_id') ?>
  <?php if($role === 1): ?>
    <div class="heading titleHead">
    <p class="headingName">Patient List</p>
    <div class="searchBar">
      <input type="search" class="searchInput" id="searchInput" placeholder="Search" />
    </div>
    </div>
    <div class="tableContainer">
      <?php if (!empty($data['patients'])): ?>
        <table class="table" id="tableData">
          <thead>
            <tr>
              <th>S.N</th>
              <th>UserId</th>
              <th>Name</th>
              <th>Username</th>
              <th>Phone</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php $index=1 ?>
          <?php foreach ($data['patients'] as $patient): ?>
            <tr key={index}>
                <td class="sn"><?= $index++ ?></td>
                <td><?= htmlspecialchars($patient['user_id']); ?></td>
                <td><?= htmlspecialchars($patient['name']); ?></td>
                <td><?= htmlspecialchars($patient['username']); ?></td>
                <td><?= htmlspecialchars($patient['phone']); ?></td>
                <td>Active</td>
                <td>
                  <button class="btn btn-primary me-2" onclick="location.href='/prescription/viewpatient/<?= $patient['user_id'] ?>'">View</button>
                </td>
            </tr>
            <?php endforeach; ?>
                 
          </tbody>
        </table>
        <?php else: ?>
          <p>No Patients found.</p>
      <?php endif; ?>
    </div>
  <?php endif; ?>
  <?php if($role === 3): ?>
    <pre>
    </pre>
    <div class="heading titleHead">
    <div class="searchBar">
      <input type="search" class="searchInput" id="searchInput" placeholder="Search" />
    </div>
    </div>
    <div class="backgroundContainer">
      <div class="recordsMenu">
          <span>Records History</span>
          <ul>
              <li class="active">All</li>
              <li>Today</li>
              <li>Yesterday</li>
              <li>Last Week</li>
              <li>Last Month</li>
              <li>Last Year</li>
          </ul>
      </div>
      <?php if (!empty($data['prescriptions'])): ?>
      <?php 
      $currentAppointmentId = null;
      foreach ($data['prescriptions'] as $index => $prescription): 
      ?>
      <?php if ($currentAppointmentId !== $prescription['appointment_id']): ?>
        <?php $currentAppointmentId = $prescription['appointment_id']; ?>
        
        <div class="records">
          <div class="date">
            <p class="day"><?= htmlspecialchars($prescription['date']); ?></p>
          </div>
          <div class="cardBody">
            <div class="cardTitle" style="display: flex; justify-content: space-between; align-items: center">
              <div>
                <div class="hospitalName">
                  <p>Family Hospital</p>
                </div>
                <div class="hospitalAddress">
                  <p>BudhanilKantha</p>
                </div>
              </div>
              <div class="generate-pdf">
                  <!-- <button onclick="window.location.href='/generatepdf/generatePatientReport?app_id=<?= $prescription['patient_id'] ?>', '_blank'"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30" onclick="window.open('/generatepdf/generatePatientReport?app_id=<?= $prescription['appointment_id'] ?>', '_blank')"><path d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 144-208 0c-35.3 0-64 28.7-64 64l0 144-48 0c-35.3 0-64-28.7-64-64L0 64zm384 64l-128 0L256 0 384 128zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z"/></svg>
                  <!-- </button> -->
              </div>
            </div>
            <div class="row cardInfo">
              <div class="col-md-4">
                <h4>Diagnosed By:</h4>
                <div class="doctorDetail">
                  <div class="doctorImage">
                      <img src="/uploads/profile_images/<?= htmlspecialchars($prescription['doctor_image']); ?>" alt="Doctor Image">
                  </div>
                  <div class="doctorProfile">
                      <p class="doctorName"><?= htmlspecialchars($prescription['doctor_name']); ?></p>
                      <p class="doctorEmail"><?= htmlspecialchars($prescription['doctor_email']); ?></p>
                  </div>
                </div>
                <div class="doctorCategory">
                  <p>Category</p>
                  <p class="doctorField"><?= htmlspecialchars($prescription['department_name']); ?></p>
                </div>
              </div>
              <div class="col-md-8">
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
                <form method="POST">
                <input type="hidden" name="recordIndex" value="<?= $index ?>">
                <!-- <button name="expand" class="expand">Expand</button> -->
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php endif; ?>

    </div>
  <?php endif; ?>
  <?php if($role === 2): ?>
    <div class="heading titleHead">
    <p class="headingName">Patient List</p>
    <div class="searchBar">
      <input type="search" class="searchInput" id="searchInput" placeholder="Search" />
    </div>
    </div>
    <div class="tableContainer">
      <?php if (!empty($data['patients'])): ?>
        <table class="table" id="tableData">
          <thead>
            <tr>
              <th>S.N</th>
              <th>UserId</th>
              <th>Name</th>
              <th>Username</th>
              <th>Phone</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php $index=1 ?>
          <?php foreach ($data['patients'] as $patient): ?>
            <tr key={index}>
                <td class="sn"><?= $index++ ?></td>
                <td><?= htmlspecialchars($patient['user_id']); ?></td>
                <td><?= htmlspecialchars($patient['name']); ?></td>
                <td><?= htmlspecialchars($patient['username']); ?></td>
                <td><?= htmlspecialchars($patient['phone']); ?></td>
                <td>Active</td>
                <td>
                  <button class="btn btn-primary me-2" onclick="location.href='/prescription/viewpatient/<?= $patient['user_id'] ?>'">View</button>
                </td>
            </tr>
            <?php endforeach; ?>
                 
          </tbody>
        </table>
        <?php else: ?>
          <p>No Patients found.</p>
      <?php endif; ?>
    </div>
    <!-- <div class="container">
      <div class="recordsMenu">
          <span>Records History</span>
          <ul>
              <li class="active">All</li>
              <li>Today</li>
              <li>Yesterday</li>
              <li>Last Week</li>
              <li>Last Month</li>
              <li>Last Year</li>
          </ul>
      </div>
      <?php if (!empty($data['appointments'])): ?>
      <?php 
      $currentAppointmentId = null;
      foreach ($data['appointments'] as $index => $appointment): 
      ?>
      <?php if ($currentAppointmentId !== $appointment['appointment_id']): ?>
        <?php $currentAppointmentId = $appointment['appointment_id']; ?>
        <div class="records">
          <div class="date">
            <p class="day"><?= htmlspecialchars($appointment['date']); ?></p>
          </div>
          <div class="cardBody">
            <div class="cardTitle">
              <div class="hospitalName">
                <p>Family Hospital</p>
              </div>
              <div class="hospitalAddress">
                <p>BudhanilKantha</p>
              </div>
            </div>
            <div class="row cardInfo">
              <div class="col-md-4">
                <h4>Diagnosed By:</h4>
                <div class="doctorDetail">
                  <div class="doctorImage">
                      <img src="" alt="Doctor Image">
                  </div>
                  <div class="doctorProfile">
                      <p class="doctorName"></strong> <?= htmlspecialchars($appointment['department_name']); ?></p>
                      <p class="doctorEmail"></strong> <?= htmlspecialchars($appointment['department_name']); ?></p>
                  </div>
                </div>
                <div class="doctorCategory">
                  <p>Category</p>
                  <p class="doctorField"></p>
                </div>
              </div>
              <div class="col-md-8">
                <div class="examination">
                  <p class="examinationTitle">Examination</p>
                  <p class="examinationDetails"><?= htmlspecialchars($appointment['examination_detail']); ?></p>
                </div>
                <div class="prescription">
                  <p class="prescriptionTitle">Prescription</p>
                  <ul class="prescriptionList">
                  <?php endif; ?>
                    <li class="medicine-item">
                      <strong>Medicine:</strong> <?= htmlspecialchars($appointment['medicine_name']); ?> 
                      <strong>Instructions:</strong> <?= htmlspecialchars($appointment['instructions']); ?>
                    </li>
                      <?php 
                        // Check if the next item has a different appointment_id or if it is the last item
                        if (!isset($data['appointments'][$index + 1]) || $data['appointments'][$index + 1]['appointment_id'] !== $currentAppointmentId): 
                      ?>
                  </ul>
                </div>
                <form method="POST">
                <input type="hidden" name="recordIndex" value="<?= $index ?>">
                <button type="submit" name="expand" class="expand">Expand</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php endif; ?>

    </div> -->
  <?php endif; ?>
        
       
 
</main>

<?php require_once '../app/views/templates/footer.php'; ?>