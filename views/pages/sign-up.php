<?php
require_once '../../dbconfig.php';

$cover = fopen('7.png','rb');
 
if($user->is_loggedin()!="")
{
    $user->redirect('home.php');
}

// Select departments query
$stmt = $DB_con->prepare("SELECT * FROM tbl_departments"); 
$stmt->execute();
$departmentList = $stmt->fetchAll();

if(isset($_POST['btn-signup']))
{
   $u_fname = trim($_POST['txt_fname']);
   $u_lname = trim($_POST['txt_lname']);
   $u_email = trim($_POST['txt_email']);
   $u_department = trim($_POST['txt_department']); 
   $u_pass = trim($_POST['txt_pass']); 
   
 
   if($u_fname=="") {
      $error[] = "provide a first name !"; 
   }
   else if($u_lname=="") {
      $error[] = "provide a last name !"; 
   }
   else if($u_email=="") {
      $error[] = "provide email !"; 
   }
   else if(!filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
   }
   else if($u_department=="") {
      $error[] = "provide department section !"; 
   }
   else if($u_pass=="") {
      $error[] = "provide password !";
   }
   else if(strlen($u_pass) < 6){
      $error[] = "Password must be atleast 6 characters"; 
   }
   else
   {
      try
      {
         $stmt = $DB_con->prepare("SELECT user_email FROM tbl_users WHERE user_email = :u_email");
         $stmt->execute(array(':u_email'=>$u_email));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if ($row['user_email']==$u_email) {
            $error[] = "sorry username already taken !";
         } else {
            if($user->register($u_fname,$u_lname,$u_email,$u_department,$u_pass)) 
            {
                $user->redirect('sign-up.php?joined');
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}
include '../partials/header.php';
?>
<div class="container">
     <div class="form-container">
        <form method="post">
            <h2>Sign up.</h2><hr />
            <?php
                if(isset($error)) {
                    foreach($error as $error) : ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                  </div>
            <?php endforeach; 
                } else if(isset($_GET['joined'])) { ?>
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                </div>
            <?php } ?>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_fname" placeholder="Enter first name" value="<?php if(isset($error)){echo $u_fname;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_lname" placeholder="Enter last name" value="<?php if(isset($error)){echo $u_lname;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_email" placeholder="Enter E-Mail" value="<?php if(isset($error)){echo $u_email;}?>" />
            </div>
            <div class="form-group">
                <select class="form-control" name="txt_department">
                    <option value="0">Select Department</option>
                    <?php foreach ($departmentList as $department): ?>
                        <option value="<?= $department['department_id'] ?>"><?= $department['department_name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
             <input type="password" class="form-control" name="txt_pass" placeholder="Enter Password" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">
                 <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>have an account ! <a href="../../index.php">Sign In</a></label>
        </form>
       </div>
</div>

</body>
</html>