<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading">
        <p class="headingName">Patient List</p>
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
                    <a href="" class="btn btn-primary me-2">Edit</a>
                    <button class='btn btn-danger'>Deactivate</button>
                </td>
            </tr>
            <?php endforeach; ?>
                 
          </tbody>
        </table>
        <?php else: ?>
          <p>No Patients found.</p>
      <?php endif; ?>
    </div>


</main>