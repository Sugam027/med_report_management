

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medilog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['base_url']; ?>css/index.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['base_url']; ?>css/login.css">
</head>
<body>
    <div class="background">
        <div class="mainComponent">
            <div class="col-md-6 infoSide">
                <div class="backgroundImage">
                    <img src="<?php echo $GLOBALS['base_url']; ?>images/poster.png" alt="">
                </div>
                <div class="info">
                    <div class="logo">
                    <img src="<?php echo $GLOBALS['base_url']; ?>images/logo.png" alt="">
                    </div>
                    <p class="slogon">
                    Connecting You to Your Health History 
                    </p>
                    <p class="description">It establishes a link between an individual and their comprehensive health records, enabling seamless access to past medical information, treatments, diagnoses, and other relevant data.</p>
                </div>
            </div>
            <div class="col-md-6 loginSide">
                <h2>Login</h2>
                
                <form action="<?php echo BASE_URL; ?>" method="POST">
                    <div class="form-group">
                        <a class='text-danger'>
                        </a>
                        <!-- <input type="text" class='form-control' placeholder='Username' name="username"> -->
                        <input type="text" class="form-control <?php echo !empty($data['username_error']) ? 'is-invalid' : ''; ?>" placeholder="Username" name="username">
                        <span class="text-danger"><?php echo $data['username_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <a class='text-danger'>
                        </a>
                        <!-- <input type="password" class='form-control' placeholder='Password' name="password"> -->
                        <input type="password" class="form-control <?php echo !empty($data['password_error']) ? 'is-invalid' : ''; ?>" placeholder="Password" name="password">
                        <span class="text-danger"><?php echo $data['password_error']; ?></span>
                    </div>
                    <button class="btn" type="submit">Login</button>
                </form>
                <p class="forgotPassword">Forgot your password?</p>
            </div>
        </div>
    </div>
</body>
</html>
