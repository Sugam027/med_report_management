<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading">
    <p class="headingName">Register user</p>
  </div>

  <div class="registerUser">
    <div class="container">
      <form id="register-form" action="" method="POST">
        <div class="row mb-2">
          <div class="form-group">
            <label>
              Role:
              
            </label>
            <select
              name="role"
              id="role-select"
              class="form-control">
              <option value="" disabled selected> --Select Role-- </option> 
              <?php foreach($data['roles'] as $role): ?>
                <option name="role" value="<?= $role->id; ?>"><?= $role->title; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input
              type="text"
              name="username"
              class="form-control"
              id="username"
              placeholder="Username"
              readOnly
            >
          </div>
          <div class="form-group">
            <input
              type="hidden"
              id="password"
              name="password"
              class="form-control"
            >
          </div>
        </div>
        <p class="title">Personal details</p>
        <div class="row mb-2">
          <div class="form-group">
            <label>Full name</label>
            <input
              type="text"
              name="full_name"
              value=""
              oninput="handleFullNameChange(this.value)"
              class="form-control"
              placeholder="Fullname"
            >
          </div>
          <div class="form-group">
            <label>DOB</label>
            <input
              type="date"
              name="dob"
              class="form-control"
              oninput="handleDobChange(this.value)"
              placeholder="dob"
            >
          </div>
          <div class="form-group">
            <label>
              Gender:
              <a class="text-danger">
              </a>
            </label>
            <select
              name="gender"
              id="gender-select"
              defaultValue=""
              class="form-control">
              <option value="" disabled selected>
                --Select Gender--
              </option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="others">Others</option>
            </select>
          </div>
          <div class="form-group">
            <label>Age</label>
            <input
              type="number"
              id="age"
              name="age"
              class="form-control"
              placeholder="Age"
              readOnly
            >
          </div>
          <div class="form-group">
            <label>
              Blood Group:
              <a class="text-danger">
                
              </a>
            </label>
            <select
              name="blood_group"
              id="blood_select"
              defaultValue=""
              class="form-control">
              <option value="" disabled selected>
                --Select Blood Group--
              </option>
              <option value="unknown">Unknown</option>
              <option value="A+">A+</option>
              <option value="A-">A-</option>
              <option value="B+">B+</option>
              <option value="B-">B-</option>
              <option value="AB+">AB+</option>
              <option value="AB-">AB-</option>
              <option value="O+">O+</option>
              <option value="O-">O-</option>
            </select>
          </div>
          <div class="form-group">
            <label>Father name</label>
            <input
              type="text"
              name="father_name"
              class="form-control"
              placeholder="Fathername"
            >
            
          </div>
          <div class="form-group">
            <label>Mother name</label>
            <input
              type="text"
              name="mother_name"
              class="form-control"
              placeholder="Mothername"
            >
          </div>
          
        </div>
        
          
        
        <p class="title">Contact details</p>
        <div class="row mb-2">
          <div class="form-group">
            <label>Email</label>
            <input
              type="email"
              name="email"
              class="form-control"
              placeholder="Email"
            >
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input
              type="text"
              name="phone"
              class="form-control"
              placeholder="Phone"
            >
          </div>
        </div>
        <div id="doctor-details">
          <p class="title">Doctor details</p>
          <div class="row mb-2">
          <div class="form-group">
              <label>
                Department:
                <a class="text-danger">
                  
                </a>
              </label>
              <select
                name="department_id"
                defaultValue=""
                class="form-control">
                <option value="" disabled selected> --Select Department-- </option> 
                <?php foreach($data['departments'] as $department): ?>
                  <option name="department_id" value="<?= $department['id']; ?>"><?= $department['name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>License Number:</label>
              <input
                type="text"
                name="license_number"
                class="form-control"
                placeholder="License number"
              >
            </div>
            <div class="form-group">
              <label>No.of Experience</label>
              <input
                type="number"
                id="experience"
                name="experience_years"
                class="form-control"
                placeholder="No. of experience"
              >
            </div>
            
          </div>
        </div>
        <p class="title">Address Details</p>
        <!-- <div class="row mb-2">
          <div class="form-group">
            <label>Province</label>
            <select
              defaultValue=""
              name="perProvince"
              class="form-control">
              <option value="" disabled>
                -- Select Province --
              </option>
              
            </select>
          </div>

          <div class="form-group">
            <label>District</label>
            <select
              defaultValue=""
              name="perDistrict"
              class="form-control">
              <option value="" disabled>
                -- Select District --
              </option>
              
            </select>
          </div>
          <div class="form-group">
            <label>Municipality</label>

            <select
              defaultValue=""
              name="perMunicipality"
              class="form-control">
              <option value="" disabled>
                -- Select Municipality --
              </option>
              
            </select>
          </div>
          <div class="form-group">
            <label>Ward No: </label>
            
            <input
              type="number"
              name="perWard"
              class="form-control"
            >
          </div>
          <div class="form-group">
            <label>Tole: </label>
            
            <input
              type="text"
              name="perTole"
              class="form-control"
            >
          </div>
        </div> -->
        <div class="row mb-2">
          <div class="form-group">
          <label>Permanent Address: </label>
            <input
              type="text"
              name="permanent_address"
              class="form-control"
              placeholder="municipality-ward, district"
            >
          </div>
        
          <div class="form-group">
            <label>Temporary Address: </label>
            <input
              type="text"
              name="temporary_address"
              class="form-control"
              placeholder="municipality-ward, district"
            >
          </div>
        </div>
        <div class="button-group">
          <button type="submit" class="btn btnSubmit">
            Register
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register-form');

    if (!form) {
    console.error('Form element not found.');
    return;
    }

   // console.log('Form validation initialized');

    form.addEventListener('submit', function (event) {
      let isValid = true;

      // Clear all previous error messages
      const errorElements = document.querySelectorAll('.error-message');
      errorElements.forEach(el => el.remove());

      // Helper function to show error
      const showError = (element, message) => {
        const error = document.createElement('span');
        error.className = 'error-message text-danger';
        error.textContent = message;
        element.parentNode.appendChild(error);
        isValid = false;
      };

      // Validate Role
      const roleSelect = document.getElementById('role-select');
      if (roleSelect.value === '') {
        showError(roleSelect, 'Please select a role.');
      }

      // Validate Full Name
      const fullName = form.querySelector('input[name="full_name"]');
      const nameRegex = /^[a-zA-Z\s]+$/; // Allows only letters and spaces
      if (!fullName.value.trim()) {
        showError(fullName, 'Full name is required.');
      } else if (!nameRegex.test(fullName.value.trim())) {
        showError(fullName, 'Full name must not contain numbers or special characters.');
      } else if (fullName.value.trim().length < 3) {
        showError(fullName, 'Full name must be at least 3 characters long.');
      }

       // Validate DOB
       const dob = form.querySelector('input[name="dob"]');
      if (!dob.value.trim()) {
        showError(dob, 'Date of birth is required.');
      } else {
        const dobDate = new Date(dob.value);
        const today = new Date();
        const age = today.getFullYear() - dobDate.getFullYear();
        const isBirthdayPassed = (
          today.getMonth() > dobDate.getMonth() || 
          (today.getMonth() === dobDate.getMonth() && today.getDate() >= dobDate.getDate())
        );

        if (age < 0 || age > 120) {
          showError(dob, 'Please enter a valid date of birth.');
        }
      }

      // validate gender
      const genderSelect = document.getElementById('gender-select');
      if (genderSelect.value === '') {
        showError(genderSelect, 'Please select a gender.');
      }

      // validate gender
      const bloodSelect = document.getElementById('blood_select');
      if (bloodSelect.value === '') {
        showError(bloodSelect, 'Please select a Blood group.');
      }

      // validate Father Name
      const fatherName = form.querySelector('input[name="father_name"]');
      if (!fatherName.value.trim()) {
        showError(fatherName, 'Father name is required.');
      } else if (!nameRegex.test(fatherName.value.trim())) {
        showError(fatherName, 'Father name must not contain numbers or special characters.');
      } else if (fatherName.value.trim().length < 3) {
        showError(fatherName, 'Father name must be at least 3 characters long.');
      }

      // validate Mother Name
      const motherName = form.querySelector('input[name="mother_name"]');
      if (!motherName.value.trim()) {
        showError(motherName, 'Mother name is required.');
      } else if (!nameRegex.test(motherName.value.trim())) {
        showError(motherName, 'Mother name must not contain numbers or special characters.');
      } else if (motherName.value.trim().length < 3) {
        showError(motherName, 'Mother name must be at least 3 characters long.');
      }

      // Validate Email
      const email = form.querySelector('input[name="email"]');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!email.value.trim()) {
        showError(email, 'Email is required.');
      } else if (!emailRegex.test(email.value.trim())) {
        showError(email, 'Invalid email format.');
      }

      // Validate Phone
      const phone = form.querySelector('input[name="phone"]');
      const phoneRegex = /^\d{10}$/; // Example for 10-digit numbers
      if (!phone.value.trim()) {
        showError(phone, 'Phone number is required.');
      } else if (!phoneRegex.test(phone.value.trim())) {
        showError(phone, 'Phone number must be 10 digits.');
      }

      // Validate Department for Doctor
      const departmentSelect = form.querySelector('select[name="department_id"]');
      if (departmentSelect && departmentSelect.value === '') {
        showError(departmentSelect, 'Please select a department.');
      }

      // validate address
      const peraddress = form.querySelector('input[name="permanent_address"]');
      if (!peraddress.value.trim()) {
        showError(peraddress, 'Address is required.');
      }

      const tempaddress = form.querySelector('input[name="temporary_address"]');
      if (!tempaddress.value.trim()) {
        showError(tempaddress, 'Address is required.');
      }

     // Prevent form submission if validation fails
     if (!isValid) {
      event.preventDefault(); // Prevent submission
    } else {
      // Allow form submission only if valid
      form.submit();
    }
  });
});

</script>


<?php require_once '../app/views/templates/footer.php'; ?>
