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
      <form action="" method="post">
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
                defaultValue=""
                class="form-control">
                <option value="" disabled selected> --Select Department-- </option> 
                <?php foreach($data['departments'] as $department): ?>
                  <option name="department_id" value="<?= $department['id']; ?>"><?= $department['name']; ?></option>
                <?php endforeach; ?>
              </select>
          </div>

          <div class="form-group">
            <label>Consultant Doctor</label>
            <select
              name="doctor_id"
              id=""
              class="form-control">
              <option value="undefined" disabled selected> --Select Doctor-- </option> 
              
            </select>
          </div>
           
           
          
        </div>
       
        <div class="button-group">
          <button type="submit" class="btn btnSubmit">
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
          console.log('Doctors for selected department:', data);
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
</script>

<?php require_once '../app/views/templates/footer.php'; ?>