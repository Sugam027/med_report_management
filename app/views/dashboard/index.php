<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading">
    <p class="headingName">Dashboard</p>
  </div>
  <div class="dashboardContainer">
    <?php if(SESSION::get('role_id') !== 3): ?>
    <div class="row">
      <div class="list">
        <p class="title">Total users</p>
        <p><?= $data['totalUsers']['total_users'] ?></p>
      </div>
      <div class="list">
        <p class="title">Total Doctors</p>
        <p><?= $data['totalDoctors']['total_users'] ?></p>
      </div>
      <div class="list">
        <p class="title">Total Patients</p>
        <p><?= $data['totalPatients']['total_users'] ?></p>
      </div>
      <div class="list">
        <p class="title">Total Appointments</p>
        <p><?= $data['totalAppointments']['total_users'] ?></p>
      </div>
    </div>
    <?php endif; ?>
    <?php if(SESSION::get('role_id') == 3): ?>
    <div class="row">
      <div class="list">
        <p class="title">Total Visits</p>
        <p><?= $data['totalVisited'] ?></p>
      </div>
      <div class="list">
        <p class="title">Total Doctors</p>
        <p><?= $data['totalDoctors']['total_users'] ?></p>
      </div>
    </div>
    <?php endif; ?>
  </div>

</main>

<?php require_once '../app/views/templates/footer.php'; ?>