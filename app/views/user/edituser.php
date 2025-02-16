<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  
  <div class="heading">
    <p class="headingName">Edit User</p>
  </div>

  <div class="registerUser">
    <div class="container">
      <form id="edit-form" action="" method="POST">
        <input type="hidden" name="user_id" value="<?= $data['user']['user_id']; ?>">

        <div class="row mb-2">
          <div class="form-group">
            <label>Role:</label>
            <select name="role" id="role-select" class="form-control" disabled>
              <option value="" disabled> --Select Role-- </option>
              <?php foreach ($data['roles'] as $role): ?>
                <option value="<?= $role->id; ?>" <?= ($data['user']['role_id'] == $role->id) ? 'selected' : ''; ?>>
                  <?= $role->title; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $data['user']['username']; ?>" readonly disabled>
          </div>
        </div>

        <p class="title">Personal details</p>
        <div class="row mb-2">
            <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?= $data['user']['full_name']; ?>" readonly disabled>
            </div>
            <div class="form-group">
                <label>DOB</label>
                <input type="date" name="dob" class="form-control" value="<?= $data['user']['dob']; ?>">
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <select name="gender" class="form-control">
                    <option value="male" <?= ($data['user']['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?= ($data['user']['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="others" <?= ($data['user']['gender'] == 'others') ? 'selected' : ''; ?>>Others</option>
                </select>
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" class="form-control" value="<?= $data['user']['age']; ?>" readonly>
            </div>
            <?php
                $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                $selectedBloodGroup = $data['user']['blood_group'] ?? '';
            ?>

            <div class="form-group">
                <label>Blood Group:</label>
                <select name="blood_group" class="form-control">
                    <?php foreach ($bloodGroups as $bloodGroup): ?>
                        <option value="<?= $bloodGroup; ?>" <?= ($selectedBloodGroup == $bloodGroup) ? 'selected' : ''; ?>>
                            <?= $bloodGroup; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
            <label>Father name</label>
            <input
              type="text"
              name="father_name"
              class="form-control"
              placeholder="Fathername"
              value="<?= $data['user']['father_name']; ?>"
            >
            
          </div>
          <div class="form-group">
            <label>Mother name</label>
            <input
              type="text"
              name="mother_name"
              class="form-control"
              placeholder="Mothername"
              value="<?= $data['user']['mother_name']; ?>"
            >
          </div>
        </div>


        <p class="title">Contact details</p>
        <div class="row mb-2">
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $data['user']['email']; ?>">
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= $data['user']['phone']; ?>">
          </div>
        </div>

        <?php if ($data['user']['role_id'] == 2): // Assuming 2 is Doctor ?>
          <div id="doctor-details">
            <p class="title">Doctor Details</p>
            <div class="row mb-2">
              <div class="form-group">
                <label>Department:</label>
                <select name="department_id" class="form-control">
                  <option value="" disabled> --Select Department-- </option>
                  <?php foreach ($data['departments'] as $department): ?>
                    <option value="<?= $department['id']; ?>" <?= ($data['user']['department_id'] == $department['id']) ? 'selected' : ''; ?>>
                      <?= $department['name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>License Number:</label>
                <input type="text" name="license_number" class="form-control" value="<?= $data['user']['license_number']; ?>">
              </div>'
              <div class="form-group">
                <label>No. of Experience</label>
                <input type="number" name="experience_years" class="form-control" value="<?= $data['user']['experience_years']; ?>">
              </div>
            </div>
          </div>
        <?php endif; ?>

        <p class="title">Address Details</p>
        <div class="row mb-2">
          <div class="form-group">
            <label>Permanent Address:</label>
            <input type="text" name="permanent_address" class="form-control" value="<?= $data['user']['permanent_address']; ?>">
          </div>
          <div class="form-group">
            <label>Temporary Address:</label>
            <input type="text" name="temporary_address" class="form-control" value="<?= $data['user']['temporary_address']; ?>">
          </div>
        </div>

        <div class="button-group">
          <button type="submit" class="btn btnSubmit">Update</button>
          <div class="loader" id="loader" style="display: none"></div>

        </div>
      </form>
    </div>
  </div>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('edit-form');
    const loader = document.getElementById('loader');


    form.addEventListener('submit', function (event) {
      let isValid = true;
      const showError = (element, message) => {
        const error = document.createElement('span');
        error.className = 'error-message text-danger';
        error.textContent = message;
        element.parentNode.appendChild(error);
        isValid = false;
      };

      // Validate Full Name
      const fullName = form.querySelector('input[name="full_name"]');
      if (!fullName.value.trim()) {
        showError(fullName, 'Full name is required.');
      }

      // Validate Email
      const email = form.querySelector('input[name="email"]');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!email.value.trim() || !emailRegex.test(email.value.trim())) {
        showError(email, 'Invalid email format.');
      }

      if (!isValid) event.preventDefault();
      loader.style.display = 'block';
    });
  });
</script>

<?php require_once '../app/views/templates/footer.php'; ?>
