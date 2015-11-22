<?php
    require_once 'dbconfig.php';
    
    if(!empty($user->is_loggedin())) {
        $user->redirect('http://localhost:8888/projectCenter/views/pages/home.php');
    }

    if(isset($_POST['btn-login'])) {
        $u_email = $_POST['txt_u_email'];
        $u_pass = $_POST['txt_u_pass'];
    
        if($user->login($u_email,$u_pass)) {
            $user->redirect('views/pages/home.php?userLoggedIn');
        } else {
            $error = "Wrong Details! Please try again...";
        }  
    }
    include 'views/partials/header.php';
?>
<div class="container login">
    <form method="post" autocomplete="false">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
            </div>
        <?php endif; ?>
        <div class="text-center mt40">
            <img src="assets/img/logo.png" class="login-logo mb15">
            <h4>Project Center</h4>
        </div>
        <div class="mt40">
            <div class="input-group mb15">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-envelope-o"></i></span>
                <input type="email" class="form-control" name="txt_u_email" placeholder="Your E-mail" required />
            </div>
            <div class="input-group mb25">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="txt_u_pass" placeholder="Your Password" required />
            </div>
            <div class="form-group">
             <button type="submit" name="btn-login" class="btn-block btn-login">LOGIN</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>