<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="container">
    <div class="recordsMenu">
        <span>Records History</span>
        <ul>
        <li class='active map'>All</li>
        <li class='today'>Today</li>
        <li class='yesterday'>Yesterday</li>
        <li class='lastWeek'>Last Week</li>
        <li class='lastMonth'>Last Month</li>
        <li class='lastYear'>Last Year</li>
        </ul>

    </div>
    <div>
        <div class="records" key={index}>
        <div class="date">
            <p class="day"></p>
        </div>
        <div class="cardBody">
            <div class="cardTitle">
            <div class="hospitalName">
                <p>Family Dental Care</p>
            </div>
            <div class="hospitalAddress">
                <p>Budhanilkantha, Kathmandu</p>
            </div>
            </div>
            <div class=" row cardInfo">
            <div class="col-md-6">
                <h4>Diagnosed By:</h4>
                <div class="doctorDetail">
                <div class="doctorImage">
                    <img src="" alt="">
                </div>
                <div class="doctorProfile">
                    <p class="doctorName">Ram</p>
                    <p class="doctorEmail">982232</p>
                </div>
                </div>
                <div class="doctorCategory">
                <p>Category</p>
                <p class="doctorField">Dental</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="examination">
                <p class="examinationTitle">Examination</p>
                <p class="examinationDetails"></p>
                </div>
                <div class="prescription">
                <p class="prescriptionTitle">Prescription</p>
                <ul class="prescriptionList">
                <li key={index} class="prescriptionItem">
                    Cetamol <span>on</span> morning <span>till</span> 7 days
                </li>
                </ul>
                </div>
                <div class="expandButton">
                <p class="expand">Expand</p>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="records" key={index}>
        <div class="date">
            <p class="day"></p>
        </div>
        <div class="cardBody">
            <div class="cardTitle">
            <div class="hospitalName">
                <p>Family Dental Care</p>
            </div>
            <div class="hospitalAddress">
                <p>Budhanilkantha, Kathmandu</p>
            </div>
            </div>
            <div class=" row cardInfo">
            <div class="col-md-6">
                <h4>Diagnosed By:</h4>
                <div class="doctorDetail">
                <div class="doctorImage">
                    <img src="" alt="">
                </div>
                <div class="doctorProfile">
                    <p class="doctorName">Ram</p>
                    <p class="doctorEmail">982232</p>
                </div>
                </div>
                <div class="doctorCategory">
                <p>Category</p>
                <p class="doctorField">Dental</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="examination">
                <p class="examinationTitle">Examination</p>
                <p class="examinationDetails"></p>
                </div>
                <div class="prescription">
                <p class="prescriptionTitle">Prescription</p>
                <ul class="prescriptionList">
                <li key={index} class="prescriptionItem">
                    Cetamol <span>on</span> morning <span>till</span> 7 days
                </li>
                </ul>
                </div>
                <div class="expandButton">
                <p class="expand">Expand</p>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="records" key={index}>
        <div class="date">
            <p class="day"></p>
        </div>
        <div class="cardBody">
            <div class="cardTitle">
            <div class="hospitalName">
                <p>Family Dental Care</p>
            </div>
            <div class="hospitalAddress">
                <p>Budhanilkantha, Kathmandu</p>
            </div>
            </div>
            <div class=" row cardInfo">
            <div class="col-md-6">
                <h4>Diagnosed By:</h4>
                <div class="doctorDetail">
                <div class="doctorImage">
                    <img src="" alt="">
                </div>
                <div class="doctorProfile">
                    <p class="doctorName">Ram</p>
                    <p class="doctorEmail">982232</p>
                </div>
                </div>
                <div class="doctorCategory">
                <p>Category</p>
                <p class="doctorField">Dental</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="examination">
                <p class="examinationTitle">Examination</p>
                <p class="examinationDetails"></p>
                </div>
                <div class="prescription">
                <p class="prescriptionTitle">Prescription</p>
                <ul class="prescriptionList">
                <li key={index} class="prescriptionItem">
                    Cetamol <span>on</span> morning <span>till</span> 7 days
                </li>
                </ul>
                </div>
                <div class="expandButton">
                <p class="expand">Expand</p>
                </div>
            </div>
            </div>
        </div>
        </div>
        
        
    </div>
    </div>

</main>

