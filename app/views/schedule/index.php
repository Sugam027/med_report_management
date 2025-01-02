<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading titleHead">
    <p class="headingName">Doctor timing</p>
    <!-- <div class="searchBar">
      <img src="../images/search.png" alt="">
      <input type="search" class="form-control" placeholder="Search" />
    </div> -->
    <div class="button-group">
    <a href="/schedule/manage_schedule"><p class="btn">Manage Schedule</p></a>
    </div>
  </div>
  <!-- <div class="container"> -->
    <div class="tableContainer">
      <?php if (!empty($data['scheduleData'])): ?>
        <table class="table">
          <thead>
            <tr>
              <th>S.N</th>
              <th>Name</th>
              <th>Shift</th>
              <th>Start time</th>
              <th>End time</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <tbody></tbody>
          <?php $index = 1; ?>
          <?php foreach ($data['scheduleData'] as $sData): ?>
            <tr>
                <td><?= $index++ ?></td>
                <td><?= htmlspecialchars($sData['doctor_name']); ?></td>
                <td><?= htmlspecialchars($sData['shift']); ?></td>
                <td><?= htmlspecialchars($sData['start_time']); ?></td>
                <td><?= htmlspecialchars($sData['end_time']); ?></td>
                <td><?= htmlspecialchars($sData['status']); ?></td>
                <td>
                  <a href="/schedule/manage_schedule?user_id=<?= $sData['user_id']; ?>" class="btn btn-primary me-2">Edit</a>
                </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No schedule found.</p>
      <?php endif; ?>
    </div>
  <!-- </div> -->

 
</main>
<?php require_once '../app/views/templates/footer.php'; ?>