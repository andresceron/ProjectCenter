<?php
session_start();
require_once 'dbconfig.php';

if ($user->is_loggedin()!="") {
    $user->redirect('home.php'); // If user logged redirect to home.php
}

if(isset($_POST['btn-login'])) { // If logging in with
    $uname = $_POST['txt_uname_email']; // Username or
    $umail = $_POST['txt_uname_email']; // Email and
    $upass = $_POST['txt_password']; // Password
      
    if($user->login($uname,$umail,$upass)) {
        $user->redirect('home.php');
    } else {  
        $error = "Wrong Details !";
    } 
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login : cleartuts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form method="post">
                <h2>Sign in.</h2><hr />
                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                    </div>
                <?php } ?>
                <div class="form-group">
                    <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID" required />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="txt_password" placeholder="Your Password" required />
                </div>
                <div class="clearfix"></div>
                <hr />
                <div class="form-group">
                    <button type="submit" name="btn-login" class="btn btn-block btn-primary">
                        <i class="glyphicon glyphicon-log-in"></i> LOGIN
                    </button>
                </div>
                <br />
                <a href="sign-up.php">Register</a>
            </form>
        </div>
    </div>
</body>
</html>