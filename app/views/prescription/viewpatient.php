<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <!-- <pre>
        <?php
            print_r($data['patients']);
        ?>
    </pre> -->

    <div class="heading titleHead">
        <p class="headingName">Patient Info</p>
        <div class="button-group">
            <a href="/prescription"><p class="btn">Back</p></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="profileCard">
                <div class="profileCardImage">
                    <img src="/uploads/profile_images/<?= $data['patients']['image'] ?>" alt="" width="100%" height="100%">
                </div>
                <div class="profileCardName"><?= $data['patients']['name'] ?></div>
                <div class="profileCardAge">Age: <?= $data['patients']['age'] ?></div>
            </div>
            <div class="profileInfo">
                <p class="profileCardTitle">Information</p>
                <div class="profileInfoList">
                    <p class="field">Gender:</p>
                    <p class="value"><?= $data['patients']['gender'] ?></p>
                </div>
                <div class="profileInfoList">
                    <p class="field">Blood Type:</p>
                    <p class="value"><?= $data['patients']['blood_group'] ?></p>
                </div>
                <div class="profileInfoList">
                    <p class="field">User Id:</p>
                    <p class="value"><?= $data['patients']['user_id'] ?></p>
                </div>
                <div class="profileInfoList">
                    <p class="field">Phone:</p>
                    <p class="value"><?= $data['patients']['phone'] ?></p>
                </div>
                <div class="profileInfoList">
                    <p class="field">DoB:</p>
                    <p class="value"><?= $data['patients']['dob'] ?></p>
                </div>
                <div class="profileInfoList">
                    <p class="field">Address:</p>
                    <p class="value"><?= $data['patients']['permanent_address'] ?></p>
                </div>

            </div>
        </div>
        <div class="col-md-8">
            <div class="prescriptionCard">
            <p class="profileCardTitle">Prescriptions</p>
            <?php if (!empty($data['prescriptions'])): ?>
      <?php 
      $currentAppointmentId = null;
      foreach ($data['prescriptions'] as $index => $prescription): 
      ?>
      <?php if ($currentAppointmentId !== $prescription['appointment_id']): ?>
        <?php $currentAppointmentId = $prescription['appointment_id']; ?>
        <div class="records">
          <div class="date">
            <p class="day" id="day"><?= htmlspecialchars($prescription['date']); ?></p>
          </div>
          <div class="cardBody">
            
              
            <div class="row cardInfo">
                <div class="examination">
                  <p class="examinationTitle">Diseases</p>
                  <p class="examinationDetails"><?= htmlspecialchars($prescription['disease']); ?></p>
                </div>
                <div class="examination">
                  <p class="examinationTitle">Examination</p>
                  <p class="examinationDetails"><?= htmlspecialchars($prescription['examination_detail']); ?></p>
                </div>
                <div class="prescription">
                  <p class="prescriptionTitle">Prescription</p>
                  <ul class="prescriptionList">
                  <?php endif; ?>
                    <li class="medicineItem">
                      <strong>Medicine:</strong> <span><?= htmlspecialchars($prescription['medicine_name']); ?> </span>
                      <strong>Instructions:</strong> <span><?= htmlspecialchars($prescription['instructions']); ?></span>
                    </li>
                      <?php 
                        // Check if the next item has a different appointment_id or if it is the last item
                        if (!isset($data['prescriptions'][$index + 1]) || $data['prescriptions'][$index + 1]['appointment_id'] !== $currentAppointmentId): 
                      ?>
                  </ul>
                </div>
            </div>
            <div class="generate-pdf">
                <button onclick="window.open('/generatepdf/generatePatientReport?app_id=<?= $prescription['appointment_id'] ?>', '_blank')">Generate PDF</button>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php endif; ?>
            </div>
        </div>
    </div>

</main>

<style>
    .profileCard{
        height: 230px;
        background-color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        margin-bottom: 10px;
    }
    .profileCardImage{
        width: 125px;
        height: 125px;
    }
    .profileCardImage img{
        padding: 2px;
        border-radius: 18px;
        object-fit: fill;
    }
    .profileCardName{
        font-size: 1.2rem;
        font-weight: 700;
        margin: 10px 0;
    }
    .profileCardAge{
        color: var(--light-black);
    }
    .profileInfo{
        background-color: #fff;
        padding: 20px;
        display: flex;
        flex-direction: column;
        border-radius: 10px;
        height: 270px;
    }
    .profileCardTitle{
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .profileInfoList{
        display: flex;
        gap: 10px;
        margin-top: 0.7rem;

    }
    .profileInfoList .field{
        width: 35%;
        font-weight: 600;
    }
    .profileInfoList .value{
        width: 65%;
        color: var(--light-black)
    }
    .prescriptionCard{
        height: 508px;
        background-color: #fff;
        overflow-y: auto;
        
        border-radius: 10px;
        padding: 1.2rem;
    }
</style>

<?php require_once '../app/views/templates/footer.php'; ?>
