<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    
    <div class="heading titleHead">
        <p class="headingName"><?= ($_SESSION['role_id'] === 1) ? 'All Appointments' : 'My Appointments'; ?></p>
        <div class="searchBar">
            <input type="search" class="searchInput" id="searchInput" placeholder="Search" />
        </div>
        <?= ($_SESSION['role_id'] === 1) ? ( 
        '<div class="button-group">
            <a href="/appointment/create"><p class="btn">Create new appointment</p></a>
        </div>
        '
        ) : ''; ?>
    </div>
    <!-- <div class="tableContainer">
      <?php if (!empty($data['appointments'])): ?>
        <table class="table">
        <thead>
                <tr>
                    <th>S.N</th>
                    <th>Patient Name</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Time</th>
                    <?php if($_SESSION['role_id'] === 1): ?>
                    <th>Doctor Name</th>
                    <?php endif; ?>
                    <th>Status</th>
                    <?php if($_SESSION['role_id'] === 2): ?>
                    <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php $index=1 ?>
            <?php foreach ($data['appointments'] as $appointment) : ?>
                <tr key={index}>
                    <td><?= $index++ ?></td>
                    <td><?= htmlspecialchars($appointment['patient_name']) ?></td>
                    <td><?= htmlspecialchars($appointment['phone']) ?></td>
                    <td><?= htmlspecialchars($appointment['date']) ?></td>
                    <td><?= htmlspecialchars($appointment['time']) ?></td>
                    <?php if($_SESSION['role_id'] === 1): ?>
                    <td><?= htmlspecialchars($appointment['doctor_name']) ?></td>
                    <?php endif; ?>
                    <td>
                    <?= $appointment['status'] ? '<span class="status checked">Checked</span>' : '<span class="status pending">Pending</span>'; ?>
                    </td>
                    <?php if($_SESSION['role_id'] === 2): ?>
                    <td>
                    <form action="/appointment/updateStatus" method="POST" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                        <input type="hidden" name="status" value="true">
                        <button type="submit" class="btn mark-checked">C</button>
                    </form>
                    <button class="btn view-prescription" onclick="location.href='/prescription/add/<?= $appointment['appointment_id'] ?>'">
                        A
                    </button>
                    <?php if ($appointment['status']): ?>
                        <button class="btn view-prescription" onclick="location.href='/prescription/viewpatient/<?= $appointment['patient_id'] ?>'">
                            V
                        </button>
                    <?php endif; ?>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
          <p>No Appointments!</p>
      <?php endif; ?>
    </div> -->

    <div class="tableContainer">
        <h2>Today's </h2>
        <?php if (!empty($data['todaysAppointments'])): ?>
            <table class="table mb-2">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Patient Name</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <?php if ($_SESSION['role_id'] === 1): ?>
                            <th>Doctor Name</th>
                        <?php endif; ?>
                        <th>Status</th>
                        <?php if ($_SESSION['role_id'] === 2): ?>
                            <th>Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; ?>
                    <?php foreach ($data['todaysAppointments'] as $appointment): ?>
                        <tr>
                            <td class="sn"><?= $index++; ?></td>
                            <td><?= htmlspecialchars($appointment['patient_name']); ?></td>
                            <td><?= htmlspecialchars($appointment['phone']); ?></td>
                            <td><?= htmlspecialchars($appointment['date']); ?></td>
                            <td><?= htmlspecialchars($appointment['time']); ?></td>
                            <?php if ($_SESSION['role_id'] === 1): ?>
                                <td><?= htmlspecialchars($appointment['doctor_name']); ?></td>
                            <?php endif; ?>
                            <td>
                                <?= $appointment['status'] ? '<span class="status checked">Checked</span>' : '<span class="status pending">Pending</span>'; ?>
                            </td>
                            <?php if ($_SESSION['role_id'] === 2): ?>
                                <td>
                                    <?php if (!$appointment['status']): ?>
                                    <form action="/appointment/updateStatus" method="POST" style="display:inline;">
                                        <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id']; ?>">
                                        <input type="hidden" name="status" value="true">
                                        <button type="submit" class="btn mark-checked">C</button>
                                    </form>
                                    <?php endif; ?>
                                    <button class="btn view-prescription" onclick="location.href='/prescription/add/<?= $appointment['appointment_id']; ?>'">
                                        Add
                                    </button>
                                    <button class="btn view-prescription" onclick="location.href='/prescription/viewpatient/<?= $appointment['patient_id']; ?>'">
                                        View
                                    </button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p class="mb-2">No appointments for today!</p>
        <?php endif; ?>

        <h2 >Others</h2>
        <?php if (!empty($data['otherAppointments'])): ?>
            <?php include 'appointment_table.php'; ?>
        <?php else: ?>
            <p>No appointments!</p>
        <?php endif; ?>

    </div> 

</main>

<?php require_once '../app/views/templates/footer.php'; ?>