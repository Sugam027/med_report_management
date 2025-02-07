<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading titleHead">
        <p class="headingName">Doctor List</p>
        <div class="searchBar">
          <input type="search" class="searchInput" id="searchInput" placeholder="Search" />
        </div>
    </div>
    <div class="tableContainer">
      <?php if (!empty($data['doctors'])): ?>
        <table class="table">
          <thead>
            <tr>
              <th>S.N</th>
              <th>Image</th>
              <th>UserId</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Status</th>
              <?php if(Session::get('role_id') === 1): ?>
              <th>Action</th>
              <?php endif; ?>
            </tr>
          </thead>

          <tbody>
          <?php $index=1 ?>
          <?php foreach ($data['doctors'] as $doctor): ?>
            <tr key="<?= $index ?>">
                <td class="sn"><?= $index++ ?></td>
                <td>
                    <img class="pimage" src="/uploads/profile_images/<?= htmlspecialchars($doctor['image']); ?>" alt="">
                </td>
                <td><?= htmlspecialchars($doctor['user_id']); ?></td>
                <td><?= htmlspecialchars($doctor['name']); ?></td>
                <td><?= htmlspecialchars($doctor['phone']); ?></td>
                <td><?= htmlspecialchars($doctor['email']); ?></td>
                <td>
                  <?= $doctor['is_active'] ? '<span class="status checked">Active</span>' : '<span class="status pending">Inactive</span>'; ?>
                </td>
                <?php if(Session::get('role_id') === 1): ?>
                <td>
                  <a href="/user/edituser?user_id=<?= $doctor['user_id'] ?>" class="btn btn-primary me-2">Edit</a>
                  <?php if ($doctor['is_active']): ?>
                    <button class="btn btn-danger" onclick="location.href='/user/deactiveuser/<?= $doctor['user_id'] ?>'">Deactivate</button>
                  <?php else: ?>
                    <button class="btn btn-success" onclick="location.href='/user/activateuser/<?= $doctor['user_id'] ?>'">Activate</button>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
            </tr>
            <?php endforeach; ?>
                 
          </tbody>
        </table>
        <?php else: ?>
          <p>No doctors found.</p>
      <?php endif; ?>
    </div>


</main>
<?php require_once '../app/views/templates/footer.php'; ?>