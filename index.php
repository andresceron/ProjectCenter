<?php
  require_once 'dbconfig.php';

  if($user->is_loggedin()!="") {
    $user->redirect('home.php');
  }

  if(isset($_POST['btn-login'])) {
    $u_email = $_POST['txt_u_email'];
    $u_pass = $_POST['txt_u_pass'];
    
    if($user->login($u_email,$u_pass)) {
      $user->redirect('home.php?userLoggedIn');
    } else {
      $error = "Wrong Details !";
    }  
  }
?>
<!DOCTYPE html>
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
            <?php
            if(isset($error))
            {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                  </div>
                  <?php
            }
            ?>
            <div class="form-group">
             <input type="text" class="form-control" name="txt_u_email" placeholder="Your E-mail" required />
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="txt_u_pass" placeholder="Your Password" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" name="btn-login" class="btn btn-block btn-primary">
                 <i class="glyphicon glyphicon-log-in"></i>&nbsp;SIGN IN
                </button>
            </div>
            <br />
            <label>Don't have account yet ! <a href="sign-up.php">Sign Up</a></label>
        </form>
       </div>
</div>

</body>
</html>