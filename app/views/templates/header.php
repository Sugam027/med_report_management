<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <Link rel="stylesheet" type="text/css" href="/css/index.css">
    <Link rel="stylesheet" type="text/css" href="/css/admin.css">

</head>
<body>
    <?php $role = Session::get('role_id') ?>
    <?php $userId = Session::get('user_id') ?>
    <header>
        <div class="logoSection">
            <!-- <div class="menuToggle" id="nav-btn">
            <span class="line-1"></span>
            <span class="line-2"></span>
            <span class="line-3"></span>
            </div>
            <img src="../../icons/logo2.png" alt="" width="45px"/>  -->
            
            <img src="/images/logo.png" width="75%" alt="" >
        </div>
        <div class="searchSetting">
            <!-- <?php if($role === 3): ?>
            <div class="searchBar">
                <img src="/images/search.png" alt="">
                <input type="search" class="form-control" placeholder="Search" />
            </div>
            <?php endif; ?> -->
            <div></div>
            <div class="setting">
                <img src="/images/setting.png" alt="setting" >
                <div class="headerProfile">
                    <img src="/uploads/profile_images/<?= $userData['image'] ?>" alt="profile" >
                </div>
            </div>
        </div>
    </header>

    <div class="profileBackground" id="profileInfoModel">
        <a href="" class="userProfile">
            <div class="profile">
                <img src="/uploads/profile_images/<?= $userData['image'] ?>" alt="Profile Image">
            </div>
            <div class="name_details">
                <p class="name"><?= $userData['name']; ?></p>
                <p class="userName"><?= $userData['username']; ?></p>
            </div>
        </a>

        <div class="change changePicture" id="changePicture">
            <p>Change your profile</p>
        </div>
        <div class="change changePassword">
            <a href="/dashboard/changepassword">
                    <p>
                    Change your password
                </p>
                </a>
        </div>

        <a href="" class="editDetails">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="25px" height="25px">
                <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"></path>
            </svg>
            <p>
                Edit details
            </p>
        </a>

        <div class="help">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="25px" height="25px">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
            </svg>
            <p>Help and Support</p>
        </div>

        <div class="logout">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="25px" height="25px">
                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
            </svg>
            <p class="loginBtn" onclick="window.location.href='/login/logout'">Logout</p>
        </div>
    </div>

    <div class="insertProfileBackground" id="insertProfileModel" style="display: none">
        <div class="insertOverlay" id="insertOverlay"></div>
        <div class="insertContent">
            <div class="changeProfile">
                <svg class="cross" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="25" height="25"><<path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                <p>Change your picture</p>
                <span id="selectedFile" style="margin-bottom: 5px"></span>
                <form action="/user/updateprofile/" method="post" enctype="multipart/form-data">
                    <!-- <input type="hidden" name="user_id" value="<?= $userId ?>"> -->
                    <input type="file" name="image" id="updateProfile" style="display: none" >
                    <label for="updateProfile" class="btn btn-primary">Choose image</label>
                    <button type="submit" class="btn updateBtn">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="sessionMessage" class="session-message <?php echo isset($_SESSION['success']) && $_SESSION['success'] ? 'success' : 'error'; ?>">
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; ?></p>
        
        <?php 
        // Clear the session messages after displaying
        unset($_SESSION['message']);
        unset($_SESSION['success']); 
        ?>
    <?php endif; ?>
    </div>


    <script>
    // Toggle the insertProfileModel
    const insertProfileModel = document.getElementById("insertProfileModel");
    const changePictureButton = document.getElementById("changePicture");
    const insertOverlay = document.getElementById("insertOverlay");
    const selectedFile = document.getElementById("selectedFile");
    const crossMark = document.querySelector(".cross");

    // Open the model
    changePictureButton.addEventListener("click", () => {
        insertProfileModel.style.display = "flex";
    });

    // Close the model when clicking outside
    insertOverlay.addEventListener("click", () => {
        insertProfileModel.style.display = "none";
    });
    crossMark.addEventListener("click", () => {
        insertProfileModel.style.display = "none";
    });

    // Automatically show selected file name (optional)
    const updateProfileInput = document.getElementById("updateProfile");
    updateProfileInput.addEventListener("change", (e) => {
        const fileName = e.target.files[0]?.name || "No file chosen";
        selectedFile.textContent = `Selected image: ${fileName}`;
        // alert(`Selected file: ${fileName}`);
    });
</script>