<?php require_once '../app/views/templates/header.php'; ?>
<?php require_once '../app/views/templates/aside.php'; ?>

<main>
    <div class="heading">
        <p class="headingName">Change password</p>
    </div>
    <div class="container">
        <!-- <div class="change-password-form"> -->
            <form action="" method="post">
                <div class="row">
                <input type="hidden" name="user_id" value="<?= Session::get('user_id') ?>">
                    <div class='form-group'>
                        <label>New Password:
                            <a class='text-danger'>
                                <span></span>
                            </a>
                        </label>
                        <input type="password" name="password" class='form-control'>
                    </div>
                </div>
                <div class="row">
                    <div class='form-group'>
                        <label htmlFor="cpassword">Confirm Password:
                            <a class='text-danger'>
                                <span></span>
                            </a>
                        </label>
                        <input type="password" name="cpassword"  class="form-control" >
                    </div>
                </div>
                <div class="button-group">
                    <button type="submit" class='btn btnSubmit'>Change Password</button>
                </div>
            </form>
        <!-- </div> -->
    </div>
</main>
<?php require_once '../app/views/templates/footer.php'; ?>