<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading titleHead">
    <p class="headingName">Doctor timing</p>
    <div class="searchBar">
      <input type="search" class="searchInput" id="searchInput" placeholder="Search" />
    </div>
    <div class="button-group">
    <a href="/schedule/manage_schedule"><p class="btn">Manage Schedule</p></a>
    </div>
  </div>
  <?php $role = Session::get('role_id') ?>
  
  <?php if($role === 1): ?>
    <div class="tableContainer">
      <?php if (!empty($data['scheduleData'])): ?>
        <table class="table">
          <thead>
            <tr>
              <th>S.N</th>
              <th>Name</th>
              <th>Shifts</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <tbody></tbody>
          <?php $index = 1; ?>
          <?php foreach ($data['scheduleData'] as $sData): ?>
            <tr key={index}>
                <td class="sn"><?= $index++ ?></td>
                <td><?= htmlspecialchars($sData['doctor_name']); ?></td>
                <td><?= htmlspecialchars($sData['shifts']); ?></td>
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
  <?php endif; ?>

  <?php if($role === 2): ?>
    <div class="tableContainer">
      <?php if (!empty($data['scheduleData'])): ?>
        <table class="table" style="display: flex;">
          <thead>
            <tr style="display: flex; flex-direction: column;">
              <th>Day</th>
              <th>Sunday</th>
              <th>Monday</th>
              <th>Tuesday</th>
              <th>Wednesday</th>
              <th>Thursday</th>
              <th>Friday</th>
              <th>Saturday</th>
            </tr>
          </thead>

          <tbody>
          <?php $index = 1; ?>
          <?php foreach ($data['scheduleData'] as $sData): ?>
            <tr key={index}  style="display: flex; flex-direction: column;">
                <th>Shifts</th>
                <td><?= htmlspecialchars($sData['sunday']); ?></td>
                <td><?= htmlspecialchars($sData['monday']); ?></td>
                <td><?= htmlspecialchars($sData['tuesday']); ?></td>
                <td><?= htmlspecialchars($sData['wednesday']); ?></td>
                <td><?= htmlspecialchars($sData['thursday']); ?></td>
                <td><?= htmlspecialchars($sData['friday']); ?></td>
                <td><?= htmlspecialchars($sData['saturday']); ?></td>
                
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No schedule found.</p>
      <?php endif; ?>
    </div>
  <?php endif; ?>


 
</main>
<?php require_once '../app/views/templates/footer.php'; ?>