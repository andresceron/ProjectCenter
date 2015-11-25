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
   $u_type = trim($_POST['txt_usertype']);
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
   } else if($u_type=="") {
      $error[] = "Provide a usterstate for this user !";
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
            if($user->register($u_fname,$u_lname,$u_email,$u_department,$u_pass,$u_type,$u_avatar)) 
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
include '../partials/nav.php';
?>
<form method="POST">
  <div class="container-fluid new-user">
    <?php if(isset($error)) { foreach($error as $error) { ?>
      <div class="row">
        <div class="alert alert-danger col-xs-12">
          <a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
          <i class="glyphicon glyphicon-warning-sign"></i><?php echo $error; ?>
        </div>
      </div>
    <?php }} else if(isset($_GET['joined'])) { ?>
      <div class="row">
        <div class="alert alert-info">
          <a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
          <i class="fa fa-bell"></i> User successfully registered. <a href='home.php'>Back to home</a>
        </div>
      </div>        
    <?php } ?>
    <div class="panel mb0 row">
      <div class="panel-heading title-section col-xs-12">
        <h5 class="panel-title text-left">
          New user
        </h5>
      </div>
      <div class="panel-heading subheading col-xs-12">
        <p class="panel-title subtitle text-left">
          Firstname <small class="tiny">Max 30 characters</small>
        </p>
      </div>
  </div>
    <div class="panel-content row">
      <div class="input-group col-xs-12">
        <input type="text" class="form-control" name="txt_fname" placeholder="Enter first name" value="<?php if(isset($error)){echo $u_fname;}?>" />
      </div>
    </div>
    <div class="panel mb0 row">
      <div class="panel-heading subheading col-xs-12">
        <p class="panel-title subtitle text-left">
          Lastname <small class="tiny">Max 30 characters</small>
        </p>
      </div>
    </div>
    <div class="panel-content row">
      <div class="input-group col-xs-12">
        <input type="text" class="form-control" name="txt_lname" placeholder="Enter last name" value="<?php if(isset($error)){echo $u_lname;}?>" />
      </div>
    </div>
    <div class="panel mb0 row">
      <div class="panel-heading subheading col-xs-12">
        <p class="panel-title subtitle text-left">
          E-mail
        </p>
      </div>
    </div>
    <div class="panel-content row">
      <div class="input-group col-xs-12">
        <input type="email" class="form-control" name="txt_email" placeholder="Enter E-Mail" value="<?php if(isset($error)){echo $u_email;}?>" />
      </div>
    </div>
    <div class="panel mb0 row">
      <div class="panel-heading subheading col-xs-12">
        <p class="panel-title subtitle text-left">
          Password <small>Minimun 6 characters</small>
        </p>
      </div>
    </div>
    <div class="panel-content row">
      <div class="input-group col-xs-12">
        <input type="password" class="form-control" name="txt_pass" placeholder="Enter Password" />
      </div>
    </div>
    <div class="panel mb0 row">
      <div class="panel-heading subheading col-xs-12">
        <p class="panel-title subtitle text-left">
          Select Department
        </p>
      </div>
    </div>
    <div class="panel-content row">
      <div class="input-group col-xs-12">
        <select class="form-control" name="txt_department">
            <option value="0">Select Department</option>
            <?php foreach ($departmentList as $department): ?>
                <option value="<?= $department['department_id'] ?>"><?= $department['department_name'] ?></option>
            <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="panel mb0 row">
      <div class="panel-heading subheading col-xs-12">
        <p class="panel-title subtitle text-left">
          Assign an usertype
        </p>
      </div>
    </div>
    <div class="panel-content status usertypes row">
      <div class="col-xs-6">
        <input type="radio" name="txt_usertype" id="admin" value="1">
        <label for="admin" class="btn btn-block usertype border-right pt15">ADMIN</label>
      </div>
      <div class="col-xs-6">
        <input type="radio" name="txt_usertype" id="user" value="2">
        <label for="user" class="btn btn-block usertype pt15">USER</label>
      </div>  
    </div>
    <div class="panel mb0 row">
      <div class="panel-heading subheading col-xs-12">
        <p class="panel-title subtitle text-left">
          Choose an avatar
        </p>
      </div>
    </div>
    <div class="panel-content row">
      <div class="input-group col-xs-12">
        <div class="radio choose-avatar">
          <?php foreach ($displayAvatars as $row): ?>
            <div class="col-xs-3">
              <input type="radio" name="txt_avatar" id="avatar-<?= $row['avatar_id'];?>" value="<?= $row['avatar_id']; ?>">
              <label class="avatar-cc avatar-<?= $row['avatar_id'];?>" for="avatar-<?= $row['avatar_id'];?>"></label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="row">
      <button type="submit" class="btn btn-create btn-block btn-primary" name="btn-signup">
         <i class="fa fa-plus pull-left"></i>Sign Up
      </button>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <a href="../home.php" class="btn btn-block btn-outline btn-to-home mt15"><i class="fa fa-home pull-left"></i> Back to home</a>  
      </div>
    </div>      
  </div>
</form>
<?php include "../partials/footer.php"; ?>