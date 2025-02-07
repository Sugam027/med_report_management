<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
<div class="heading titleHead">
    <p class="headingName">Add Prescription</p>
    <div class="button-group">
            <a href="/prescription"><p class="btn">Back</p></a>
        </div>
  </div>
    <div class="container">
      <?php if (isset($data['appointment']) && !empty($data['appointment'])): ?>
        <p class="patientName mb-2">Patient Name: <?= htmlspecialchars($data['appointment']['patient_name']) ?></p>
      <?php endif; ?>
      <form class="prescriptionForm" id="prescriptionForm" action="" method="POST" enctype="multipart/form-data">
        <div class="form-group mb-2">
          <input type="hidden" name="appointment_id" value="<?= $data['appointment']['appointment_id'] ?>">
        </div>
        <!-- Symptoms -->
        <div class="form-group mb-2">
          <p>Symptoms</p>
          <textarea id="symptoms" name="symptoms" class="form-control"></textarea>
          <span class="text-danger" id="symptomsError"></span>
        </div>
        <!-- Vital Signs -->
        <div class="form-group mb-2">
          <p>Vital Signs</p>
          <div class="row">
            <div class="col-md-4">
              <input type="text" name="blood_pressure" placeholder="Blood Pressure" class="form-control">
            </div>
            <div class="col-md-4">
              <input type="text" name="temperature" placeholder="Temperature" class="form-control">
            </div>
            <div class="col-md-4">
              <input type="text" name="heart_rate" placeholder="Heart Rate" class="form-control">
            </div>
          </div>
          <span class="text-danger" id="vitalSignsError"></span>
        </div>

        <p>Tests</p>
        <div id="testContainer"></div>

        <!-- Test Results -->
        <!-- <div class="form-group mb-2">
          <p>Test Results</p>
          <textarea id="testResults" name="test_results" class="form-control"></textarea>
          <span class="text-danger" id="testResultsError"></span>
        </div> -->

        <!-- Test Results File Upload -->
        <!-- <div class="form-group mb-2">
          <p>Upload Test Results</p>
          <input type="file" name="test_files[]" id="testFiles" class="form-control" multiple>
          <span class="text-danger" id="testFilesError"></span>
        </div> -->

        <!-- examination details -->
        <div class="form-group mb-2">
            <p>Examination Detail</p>
            <textarea id="examinationDetail" name="examination_detail" class="form-control"></textarea>
            <span class="text-danger" id="examinationError"></span>
        </div>

        <!-- Disease -->
        <div class="form-group mb-2">
          <p>Diseases</p>
          <input type="text" name="disease" id="disease" class="form-control">
          <span class="text-danger" id="diagnosedOnError"></span>
        </div>

        <!-- prescription -->
        <p>Prescription</p>
        <div id="prescriptionContainer">
            
        </div>

        <!-- Follow-Up Date and Time -->
        <div class="row">
          <div class="form-group mb-2">
            <p>Next Follow-Up Date</p>
            <input type="date" name="follow_up_date" id="followUpDate" class="form-control" >
            <span class="text-danger" id="followUpDateError"></span>
          </div>

          <div class="form-group mb-2">
            <p>Next Follow-Up Time</p>
            <input type="time" name="follow_up_time" id="followUpTime" class="form-control" >
            <span class="text-danger" id="followUpTimeError"></span>
          </div>
        </div>

        <button class="btn btnSubmit">Save</button>
      </form>
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('prescriptionForm');

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

      // Validate disease field
      const diseaseField = document.getElementById('disease');
      if (!diseaseField.value.trim()) {
        showError(diseaseField, 'Disease field is required.');
      }

      // Validate examination detail
      const examinationField = document.getElementById('examinationDetail');
      if (!examinationField.value.trim()) {
        showError(examinationField, 'Examination detail is required.');
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
