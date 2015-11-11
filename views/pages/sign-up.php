<?php
require_once '../../dbconfig.php';
require_once '../../user_id.php';

// Select departments query
$stmt = $DB_con->prepare("SELECT * FROM tbl_departments"); 
$stmt->execute();
$departmentList = $stmt->fetchAll();

if(isset($_POST['btn-signup'])) {
   $u_fname = trim($_POST['txt_fname']);
   $u_lname = trim($_POST['txt_lname']);
   $u_email = trim($_POST['txt_email']);
   $u_department = trim($_POST['txt_department']); 
   $u_pass = trim($_POST['txt_pass']); 
   $u_avatar = "";

  if(!empty($_POST['txt_avatar'])) {
    $u_avatar = $_POST['txt_avatar'];
  } else {
    $u_avatar = "";
  }
   
 
   if($u_fname=="") {
      $error[] = "provide a first name !"; 
   } else if($u_lname=="") {
      $error[] = "provide a last name !"; 
   } else if($u_email=="") {
      $error[] = "provide email !"; 
   } else if(!filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
   } else if($u_department == "0") {
      $error[] = "provide department section !"; 
   } else if($u_pass=="") {
      $error[] = "provide password !";
   } else if(strlen($u_pass) < 6){
      $error[] = "Password must be atleast 6 characters"; 
   } else if($u_avatar == false) {
      $error[] = "Please select an avatar"; 
   } else {
      try {
         $stmt = $DB_con->prepare("SELECT user_email FROM tbl_users WHERE user_email = :u_email");
         $stmt->execute(array(':u_email'=>$u_email));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if ($row['user_email']==$u_email) {
            $error[] = "Oops! There is already an user registred with this email here!";
         } else {
            if($user->register($u_fname,$u_lname,$u_email,$u_department,$u_pass, $u_avatar)) 
            {
                $user->redirect('sign-up.php?joined');
            }
         }
     } catch(PDOException $e) {
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
            <div class="row">
              <div class="col-md-8">
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
                <div class="form-group">
                  <div class="radio">
                    <?php foreach ($displayAvatars as $row): ?>
                      <label>
                        <img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" alt="" width="140px" class="img-thumbnail" />
                        <input type="radio" name="txt_avatar" value="<?= $row['avatar_id']; ?>">
                      </label>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class="clearfix"></div><hr />
                <div class="form-group">
                 <button type="submit" class="btn btn-block btn-primary" name="btn-signup">
                     <i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                    </button>
                </div>    
              </div>
            </div>
            <br />
            <label>have an account ! <a href="../../index.php">Sign In</a></label>
        </form>
       </div>
</div>

</body>
</html>