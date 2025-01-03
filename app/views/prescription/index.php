<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <?php $role = Session::get('role_id') ?>
  <?php if($role === 1): ?>
    <div class="heading titleHead">
    <p class="headingName">Patient List</p>
    <div class="searchBar">
      <input type="search" class="searchInput" placeholder="Search" />
    </div>
    </div>
    <div class="tableContainer">
      <?php if (!empty($data['patients'])): ?>
        <table class="table">
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
                <td><?= $index++ ?></td>
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
    <div class="container">
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

    </div> 
  <?php endif; ?>
  <?php if($role === 3): ?>
    <div class="heading titleHead">
    <div class="searchBar">
      <input type="search" class="searchInput" placeholder="Search" />
    </div>
    </div>
    <div class="container">
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
                  <button onclick="window.location.href='/generatepdf/generatePatientReport?app_id=<?= $prescription['appointment_id'] ?>', '_blank'">Generate PDF</button>
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
                <div class="examination">
                  <p class="examinationTitle">Disease</p>
                  <p class="examinationDetails"><?= htmlspecialchars($prescription['disease']); ?></p>
                </div>
                <div class="examination">
                  <p class="examinationTitle">Examination</p>
                  <p class="examinationDetails"><?= htmlspecialchars($prescription['examination_detail']); ?></p>
                </div>
                <div class="prescription">
                  <p class="prescriptionTitle">Prescription</p>
                  <ul class="prescriptionList">
                  <?php endif; ?>
                    <li class="medicineItem">
                      <strong>Medicine:</strong> <?= htmlspecialchars($prescription['medicine_name']); ?> 
                      <strong>Instructions:</strong> <?= htmlspecialchars($prescription['instructions']); ?>
                    </li>
                      <?php 
                        // Check if the next item has a different appointment_id or if it is the last item
                        if (!isset($data['prescriptions'][$index + 1]) || $data['prescriptions'][$index + 1]['appointment_id'] !== $currentAppointmentId): 
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

    </div>
  <?php endif; ?>
  <?php if($role === 2): ?>
    <div class="heading titleHead">
    <p class="headingName">Patient List</p>
    <div class="searchBar">
      <input type="search" class="searchInput" placeholder="Search" />
    </div>
    </div>
    <div class="tableContainer">
      <?php if (!empty($data['patients'])): ?>
        <table class="table">
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
                <td><?= $index++ ?></td>
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