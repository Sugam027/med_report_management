<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
  <div class="heading titleHead">
    <p class="headingName">Create Appointment</p>
    <div class="button-group">
            <a href="/appointment"><p class="btn">Back</p></a>
        </div>
  </div>

  <div class="registerUser">
    <div class="container">
      <form id="create-appointment" action="" method="POST">
        <div class="row mb-2">
        <div class="form-group">
            <label>Appointment Date:</label>
            <input
              type="date"
              class="form-control"
              name="date"
            />
          </div>
          <div class="form-group">
            <label>Appointment Time</label>
            <input
              type="time"
              value=""
              name="time"
              class="form-control"
              placeholder="Appointment Time"

            />
          </div>
        </div>
        <div class="row mb-2">
          <div class="form-group">
            <label>Full name</label>
            <input
              type="text"
              name="patient_name"
              value=""
              class="form-control"
              placeholder="Fullname"
            />
          </div>
          
          <div class="form-group">
            <label>Age</label>
            <input
              type="number"
              name="age"
              class="form-control"
              placeholder="Age"
            />
          </div>
         
          <div class="form-group">
            <label>Phone</label>
            <input
              type="text"
              name="phone"
              class="form-control"
              placeholder="Phone"
            />
          </div>
        </div>
        <div class="form-group">
            <label>Symptoms </label>
            
            <textarea
              type="text"
              name="symptoms"
              class="form-control"
            ></textarea>
          </div>
        <div class="row mb-2">
          <div class="form-group">
            <label>Department</label>
            <select
                name="department_id"
                id="department-select"
                defaultValue=""
                class="form-control">
                <option value="" disabled selected> --Select Department-- </option> 
                <?php foreach($data['departments'] as $department): ?>
                  <option value="<?= $department['id']; ?>"><?= $department['name']; ?></option>
                <?php endforeach; ?>
              </select>
          </div>

          <div class="form-group">
            <label>Consultant Doctor</label>
            <select
              name="doctor_id"
              id="doctor-select"
              class="form-control">
              <option value="undefined" disabled selected> --Select Doctor-- </option> 
              
            </select>
          </div>
           
           
          
        </div>
       
        <div class="button-group">
          <button class="btn btnSubmit">
            Create
          </button>
        </div>
      </form>
    </div>
  </div>
</main>
<script>
  // Function to handle department selection
  function onDepartmentChange() {
    // Get selected department ID
    var departmentId = document.querySelector("select[name='department_id']").value;

    // Check if a department is selected
    if (departmentId) {
      // Make a GET request to fetch doctors based on department
      fetch('/appointment/getDoctorsByDepartment/' + departmentId)
        .then(response => response.json())
        .then(data => {
          // Get the doctor dropdown element
          var doctorSelect = document.querySelector("select[name='doctor_id']");

          // Clear existing options
          doctorSelect.innerHTML = '<option value="" disabled selected> --Select Doctor-- </option>';

          // Populate the doctor dropdown with new options
          data.forEach(function(doctor) {
            var option = document.createElement('option');
            option.value = doctor.user_id;
            option.textContent = doctor.doctor_name;
            doctorSelect.appendChild(option);
          });
        })
        .catch(error => console.error('Error fetching doctors:', error));
    }
  }

  // Attach event listener to department dropdown
  document.querySelector("select[name='department_id']").addEventListener("change", onDepartmentChange);

  // Form validation function
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('create-appointment');

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

      const date = document.querySelector("input[name='date']");
      const time = document.querySelector("input[name='time']");
      const patientName = document.querySelector("input[name='patient_name']");
      const age = document.querySelector("input[name='age']");
      const phone = document.querySelector("input[name='phone']");
      const symptoms = document.querySelector("textarea[name='symptoms']");
      const department = document.getElementById("department-select");
      const doctor = document.getElementById("doctor-select");

      // Validation rules
    if (!date.value) {
      showError(date, "Appointment date is required.");
      isValid = false;
    }

    if (!time.value) {
      showError(time, "Appointment time is required.");
      isValid = false;
    }

    if (!patientName.value.trim()) {
      showError(patientName, "Full name is required.");
      isValid = false;
    }

    if (!age.value || age.value < 0 || age.value > 120) {
      showError(age, "Please enter a valid age.");
      isValid = false;
    }

    if (!phone.value || !/^\d{10}$/.test(phone.value)) {
      showError(phone, "Please enter a valid 10-digit phone number.");
      isValid = false;
    }

    if (!symptoms.value.trim()) {
      showError(symptoms, "Symptoms field cannot be empty.");
      isValid = false;
    }

    if (!department.value) {
      showError(department, "Please select a department.");
      isValid = false;
    }

    if (!doctor.value) {
      showError(doctor, "Please select a consultant doctor.");
      isValid = false;
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