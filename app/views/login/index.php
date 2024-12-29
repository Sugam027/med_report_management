

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medilog</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['base_url']; ?>css/index.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['base_url']; ?>css/login.css">
</head>
<body>
    <div class="background">
        <div class="mainComponent">
            <div class="col-md-6">
                <div class="backgroundImage">
                    <img src="<?php echo $GLOBALS['base_url']; ?>images/poster.png" alt="">
                </div>
                <div class="info">
                    <div class="logo">
                    </div>
                    <p class="slogon">
                    Connecting You to Your Health History 
                    </p>
                    <p class="description">It establishes a link between an individual and their comprehensive health records, enabling seamless access to past medical information, treatments, diagnoses, and other relevant data.</p>
                </div>
            </div>
            <div class="col-md-6 loginSide">
                <h2>Login</h2>
                
                <form action="<?php echo BASE_URL; ?>login/authenticate" method="POST">
                    <div class="form-group">
                        <a class='text-danger'>
                        </a>
                        <input type="text" class='form-control' placeholder='Username' name="username">
                    </div>
                    <div class="form-group">
                        <a class='text-danger'>
                        </a>
                        <input type="password" class='form-control' placeholder='Password' name="password">
                    </div>
                    <button class="btn" type="submit">Login</button>
                </form>
                <p class="forgotPassword">Forgot your password?</p>
            </div>
        </div>
    </div>
</body>
</html>
