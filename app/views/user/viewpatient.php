<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading titleHead">
        <p class="headingName">Patient List</p>
        <div class="searchBar">
          <input type="search" class="searchInput" id="searchInput" placeholder="Search" />
        </div>
    </div>
    <div class="tableContainer">
      <?php if (!empty($data['patients'])): ?>
        <table class="table">
          <thead>
            <tr>
              <th>S.N</th>
              <th>Image</th>
              <th>UserId</th>
              <th>Name</th>
              <th>Username</th>
              <th>Phone</th>
              <th>Status</th>
              <?php if(Session::get('role_id') === 1): ?>
              <th>Action</th>
              <?php endif; ?>
            </tr>
          </thead>

          <tbody>
          <?php $index=1 ?>
          <?php foreach ($data['patients'] as $patient): ?>
            <tr key="<?= $index ?>">

                <td class="sn"><?= $index++ ?></td>
                <td>
                    <img class="pimage" src="/uploads/profile_images/<?= htmlspecialchars($patient['image']); ?>" alt="">
                </td>
                <td><?= htmlspecialchars($patient['user_id']); ?></td>
                <td><?= htmlspecialchars($patient['name']); ?></td>
                <td><?= htmlspecialchars($patient['username']); ?></td>
                <td><?= htmlspecialchars($patient['phone']); ?></td>
                <td>
                  <?= $patient['is_active'] ? '<span class="status checked">Active</span>' : '<span class="status pending">Inactive</span>'; ?>
                </td>
                <?php if(Session::get('role_id') === 1): ?>
                  <td>
                    <a href="/user/edituser?user_id=<?= $patient['user_id'] ?>" class="btn btn-primary me-2">Edit</a>
                    <?php if ($patient['is_active']): ?>
                      <button class="btn btn-danger" onclick="location.href='/user/deactiveuser/<?= $patient['user_id'] ?>'">Deactivate</button>
                    <?php else: ?>
                      <button class="btn btn-success" onclick="location.href='/user/activateuser/<?= $patient['user_id'] ?>'">Activate</button>
                    <?php endif; ?>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
                 
          </tbody>
        </table>
        <?php else: ?>
          <p>No Patients found.</p>
      <?php endif; ?>
    </div>


</main>
<?php require_once '../app/views/templates/footer.php'; ?>