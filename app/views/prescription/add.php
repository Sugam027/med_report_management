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
        <form class="prescriptionForm" id="prescriptionForm" action="" method="POST">
            <div class="form-group mb-2">
            <input type="hidden" name="appointment_id" value="<?= $data['appointment']['appointment_id'] ?>">
            </div>
                <div class="form-group mb-2">
                        <p>Diseases</p>
                        <input type="text" name="disease" id="disease" class="form-control">
                        <span class="text-danger" id="diagnosedOnError"></span>
                </div>
            <!-- <div class="form-group mb-2">
                <p>Hospital Name</p>
                <select id="hospitalSelect" class="form-control"></select>
                <span class="text-danger" id="hospitalError"></span>
            </div> -->
            <!-- <div class="row">
                <div class="col form-group mb-2">
                    <p>Diagnosed by:</p>
                    <select id="doctorSelect" class="form-control">
                        <option value="" disabled selected>Select Doctor</option>
                    </select>
                    <span class="text-danger" id="doctorError"></span>
                </div>
                <div class="col form-group mb-2">
                    <p>Diagnosed on:</p>
                    <input type="date" id="diagnosedOn" class="form-control">
                    <span class="text-danger" id="diagnosedOnError"></span>
                </div>
            </div> -->
            <div class="form-group mb-2">
                <p>Examination Detail</p>
                <textarea id="examinationDetail" name="examination_detail" class="form-control"></textarea>
                <span class="text-danger" id="examinationError"></span>
            </div>
            <p>Prescription</p>
            <div id="prescriptionContainer">
                
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
