<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading titleHead">
    <p class="headingName">Doctor Timing</p>
    <div class="button-group">
      <a href="/schedule"><p class="btn">Back</p></a>
    </div>
  </div>

  <div class="container">
    <form action="" method="post">
      <div class="manageSchedule">
        <!-- Select Doctor -->
        <div class="form-group">
          <label for="doctor">Select Doctor:</label>
          <select id="doctor" name="user_id" class="form-control" required>
              <option value="" disabled selected>Select a doctor</option>
              <?php foreach ($data['doctors'] as $doctor): ?>
                <?php $selectedDoctorId = $_GET['user_id'] ?? ''; ?>
                  <option value="<?= $doctor['user_id']; ?>" <?= $doctor['user_id'] == $selectedDoctorId ? 'selected' : ''; ?>>
                      <?= $doctor['name']; ?>
                  </option>
              <?php endforeach; ?>
          </select>
        </div>
      <?php 
      $shiftTypes = [1 => 'morning', 2 => 'evening', 3 => 'night', 4 => 'leave'];
      $daysOfWeek = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
      ?>

      <!-- Loop through shift types (morning, evening, night, leave) -->
      <?php foreach ($shiftTypes as $shiftId => $shiftType): ?>
          <div class="form-group">
              <label><?= ucfirst($shiftType) ?> shift: </label>
              <div class="form-control d-flex">
                  <?php foreach ($daysOfWeek as $day): ?>
                      <div class="dayList">
                          <input type="checkbox" name="<?= $shiftType ?>[]" 
                                value="<?= $day ?>" 
                                id="<?= $shiftType ?>_<?= $day ?>" 
                                class="shift-checkbox">
                          <label for="<?= $shiftType ?>_<?= $day ?>"><?= ucfirst($day) ?></label>
                      </div>
                  <?php endforeach; ?>
              </div>
          </div>
      <?php endforeach; ?>


      <div class="button-group">
        <button type="submit" class="btn btnSubmit">Update Schedule</button>
      </div>
      </div>
    </form>
  </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const doctorSelect = document.getElementById("doctor");
    const shiftCheckboxes = document.querySelectorAll(".shift-checkbox");
    const shiftMap = { "1": "morning", "2": "evening", "3": "night", "4": "leave" };


    // Function to fetch and populate shift data
    function fetchAndPopulateSchedule(doctorId) {
        if (!doctorId) return;

        // Clear all checkboxes
        shiftCheckboxes.forEach(checkbox => (checkbox.checked = false));

        // Fetch schedule data
        fetch('/schedule/getDoctorSchedule/' + doctorId)
            .then(response => response.json())
            .then(data => {
                if (data && data.user_id == doctorId) {
                    for (const day in data) {
                        if (day !== 'id' && day !== 'user_id' && day !== 'doctor_name' && day !== 'created_at' && day !== 'updated_at') {
                            const shiftIds = data[day].split(',');
                            shiftIds.forEach(shiftId => {
                                const shiftType = shiftMap[shiftId.trim()];
                                const checkbox = document.getElementById(`${shiftType}_${day}`);
                                if (checkbox) {
                                    checkbox.checked = true;
                                }
                            });
                        }
                    }
                }
            })
            .catch(error => console.error('Error fetching schedule data:', error))
            .finally(() => {
                // Hide loading spinner
                document.body.classList.remove('loading');
            });
    }

    // Event listener for dropdown change
    doctorSelect.addEventListener("change", function () {
        const doctorId = this.value;
        // console.log(doctorId);
        fetchAndPopulateSchedule(doctorId);
    });

    // Check for preselected doctor ID from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const preselectedDoctorId = urlParams.get("user_id");

    if (preselectedDoctorId) {
        doctorSelect.value = preselectedDoctorId; // Set the dropdown value
        fetchAndPopulateSchedule(preselectedDoctorId); // Fetch and populate the schedule
    }
});

</script>

<?php require_once '../app/views/templates/footer.php'; ?>
