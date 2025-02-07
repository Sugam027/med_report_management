<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading">
        <p class="headingName">Profile</p>
    </div>
    <div class="backgroundContainer">
        <div class="userProfileCard">
            <div class="row">
                <div class="col-md-6">
                    <div class="image mb-2">
                        <img src="/uploads/profile_images/<?= $data['user']['image'] ?>" alt="" width="100%" height="100%">
                    </div>
                    <div class="username"><?= $data['user']['name'] ?></div>
                    <div class="age">Age <?= $data['user']['age'] ?></div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <div class="fullname"><?= $data['user']['name'] ?></div>
                        <div class="department"><?= $data['user']['department_name'] ?></div>
                    </div>
                    <?php if($data['user']['role_id'] === 2): ?>
                    <div class="mb-2">
                        <strong>Experience </strong><div class="mb-2"><?= $data['user']['experience_years'] ?> years</div>
                        <strong>License No </strong><div class="mb-2"><?= $data['user']['license_number'] ?></div>
                        <strong>Types of   </strong><div><?= $data['user']['department_name'] ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="mb-2">
                        <strong>Blood Group </strong><div class="bloodType mb-2"><?= $data['user']['blood_group'] ?></div>
                        <strong>Phone </strong><div class="phone mb-2"><?= $data['user']['phone'] ?></div>
                        <strong>Email </strong><div class="email mb-2"><?= $data['user']['email'] ?></div>
                        <strong>Address </strong><div class="address"><?= $data['user']['permanent_address'] ?></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
  
</main>

<style>
    main .backgroundContainer .userProfileCard{
        width: 100%;
        background-color: #ffffff4d;
        margin-bottom: 1rem;
        padding: 0.5rem;
        box-shadow: 0px 1px 5px 0px;
        color: var(--light-black);
    }
    main .backgroundContainer .userProfileCard .row  .image{
        width: 100%;
        height: 350px;
    }
    main .backgroundContainer .userProfileCard .row  .image img{
        object-fit: contain;
    }
    main .backgroundContainer .userProfileCard .row  .username{
        font-size: 1.7rem;
        font-weight: 700;
        text-align: center;
        color: #000;
    }
    main .backgroundContainer .userProfileCard .row  .fullname{
        font-size: 1.7rem;
        font-weight: 700;
        color: #000;

    }
    main .backgroundContainer .userProfileCard .row  .age{
        font-size: 1.3rem;
        text-align: center;
    }
</style>
<?php require_once '../app/views/templates/footer.php'; ?>