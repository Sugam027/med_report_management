<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="container">
        <div class="recordsMenu">
            <span>Records History</span>
            <ul>
                <li class="active">All</li>
                <li>Today</li>
                <li>Yesterday</li>
                <li>Last Week</li>
                <li>Last Month</li>
                <li>Last Year</li>
            </ul>
        </div>

        <div>
                <div class="records">
                    <div class="date">
                        <p class="day"></p>
                    </div>

                    <div class="cardBody">
                        <div class="cardTitle">
                            <div class="hospitalName">
                                <p></p>
                            </div>
                            <div class="hospitalAddress">
                                <p></p>
                            </div>
                        </div>
                        <div class="row cardInfo">
                            <div class="col-md-6">
                                <h4>Diagnosed By:</h4>
                                <div class="doctorDetail">
                                    <div class="doctorImage">
                                        <img src="" alt="Doctor Image">
                                    </div>
                                    <div class="doctorProfile">
                                        <p class="doctorName"></p>
                                        <p class="doctorEmail"></p>
                                    </div>
                                </div>
                                <div class="doctorCategory">
                                    <p>Category</p>
                                    <p class="doctorField"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="examination">
                                    <p class="examinationTitle">Examination</p>
                                    <p class="examinationDetails"><</p>
                                </div>
                                <div class="prescription">
                                    <p class="prescriptionTitle">Prescription</p>
                                    <ul class="prescriptionList">
                                        
                                    </ul>
                                </div>
                                <form method="POST">
                                    <input type="hidden" name="recordIndex" value="<?= $index ?>">
                                    <button type="submit" name="expand" class="expand">Expand</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

            <!-- <div class="expandedDetailBackground">
                <div class="expandedMenu">
                    <form method="POST">
                        <button type="submit" class="back btn btn-secondary">Back</button>
                    </form>
                </div>
                <div class="expandedDetails">
                    <div class="hospitalInfo">
                        <div class="logo">
                            <img src="../icons/logo_green.png" alt="Logo">
                        </div>
                        <div class="hospitalDetail">
                            <p class="hospitalName"></p>
                            <p class="address">
                                
                            </p>
                        </div>
                        <div class="hospitalContact">
                            <p class="contact">Ph: </p>
                            <p class="email">Email: </p>
                            <p class="website">Website: </p>
                        </div>
                    </div>
                    <div class="patientDetail">
                        <p>Patient Info:</p>
                        <div class="row">
                            <div class="col">
                                <p class="name">Name: <?= $expandedRecord['patientId']['name'] ?></p>
                                <p class="name">Gender: Female</p>
                                <p class="name">Age: 35</p>
                            </div>
                            <div class="col">
                                <p class="name">Address:</p>
                                <p class="name">Phone: <?= $expandedRecord['patientId']['phone'] ?></p>
                            </div>
                            <div class="col-2">
                                <div class="patientImage">
                                    <img src="" alt="Patient Image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="diagnosisTitle">Diagnosis</p>
                    <div class="recordsDetail">
                        <div class="row">
                            <div class="col">
                                <p>By: <?= $expandedRecord['doctorId']['name'] ?></p>
                                <p>Category: <?= $expandedRecord['doctorId']['category'] ?></p>
                            </div>
                            <div class="col">
                                <p>Date: <?= $expandedRecord['diagnosedOn'] ?></p>
                            </div>
                        </div>
                        <div class="examinationDetail">
                            <p>Examination</p>
                            <p></p>
                        </div>
                        <div class="prescriptions">
                            <p>Prescriptions</p>
                            <ul class="prescriptionList">
                                    <li class="prescriptionItem">
                                        
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
    </div>
</main>
<?php require_once '../app/views/templates/footer.php'; ?>

