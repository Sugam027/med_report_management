<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading">
        <p class="headingName">Doctor List</p>
    </div>
    <div class="tableContainer">
      <?php if (!empty($data['doctors'])): ?>
        <table class="table">
          <thead>
            <tr>
              <th>S.N</th>
              <th>UserId</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php $index=1 ?>
          <?php foreach ($data['doctors'] as $doctor): ?>
            <tr key={index}>
                <td><?= $index++ ?></td>
                <td><?= htmlspecialchars($doctor['user_id']); ?></td>
                <td><?= htmlspecialchars($doctor['name']); ?></td>
                <td><?= htmlspecialchars($doctor['phone']); ?></td>
                <td><?= htmlspecialchars($doctor['email']); ?></td>
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
          <p>No doctors found.</p>
      <?php endif; ?>
    </div>


</main>