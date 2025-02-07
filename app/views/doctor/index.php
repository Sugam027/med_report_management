<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading">
        <p class="headingName">Doctor List</p>
    </div>
    <div class="backgroundContainer">
      <div class="cardList">
        <?php foreach ($data['doctors'] as $doctor): ?>
          <div class="card" key={index}>
            <div class="row">
              <div class="cardLeft">
                <div class="image mb-2">
                <img class="pimage" src="/uploads/profile_images/<?= htmlspecialchars($doctor['image']); ?>" alt="doctor_image" width="100%">
                </div>
                <div class="cardId">
                  <p>DID <?= htmlspecialchars($doctor['user_id']); ?></p>
                </div>
              </div>
              <div class="cardRight">
                <p class="cardName mb-2"><?= htmlspecialchars($doctor['full_name']); ?></p>
                <p class="department mb-2"><?= htmlspecialchars($doctor['department_name']); ?></p>
                <p class="phone mb-2"><?= htmlspecialchars($doctor['phone']); ?></p>
                <p class="email mb-2"><?= htmlspecialchars($doctor['email']); ?></p>
              </div>
            </div>
            <div class="viewProfile">
              <p onclick="window.location.href='/user/profile?user_id=<?= $doctor['user_id'] ?>'">View Profile</p>
            </div>
          </div>
        <?php endforeach; ?>
  
      </div>
    </div>
    <!-- <div class="tableContainer">
      <?php if (!empty($data['doctors'])): ?>
        <table class="table">
          <thead>
            <tr>
              <th>S.N</th>
              <th>image</th>
              <th>UserId</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Status</th>
            </tr>
          </thead>

          <tbody>
          <?php $index=1 ?>
          <?php foreach ($data['doctors'] as $doctor): ?>
            <tr key={index}>
                <td><?= $index++ ?></td>
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
            </tr>
            <?php endforeach; ?>
                 
          </tbody>
        </table>
        <?php else: ?>
          <p>No doctors found.</p>
      <?php endif; ?>
    </div> -->

</main>
<?php require_once '../app/views/templates/footer.php'; ?>