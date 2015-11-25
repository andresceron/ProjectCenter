<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('http://localhost:8888/projectCenter/views/pages/index.php');
	}

	shuffle($displayAvatars);

	$user_id_edit = $_SESSION['user_id_edit'];	
	$editUserInfo = $user->userData($user_id_edit);

	if(isset($_POST['btn-updateUser'])) {
		$update_firstname = $_POST['update_firstname'];
		$update_lastname = $_POST['update_lastname'];
		$update_email = $_POST['update_email'];	

		if(empty($_POST['update_avatar'])) {
			$update_avatar = $userInfo['user_avatar'];
		} else {
			$update_avatar = $_POST['update_avatar'];			
		}

	   	if(empty($update_firstname)) {
	     	$error[] = "provide a first name!"; 
	   	} else if(empty($update_lastname)) {
	    	$error[] = "provide a last name!"; 
	   	} else if(empty($update_email)) {
	    	$error[] = "provide email!"; 
	   	} else {
    		if($user->update_user($update_firstname, $update_lastname, $update_email, $update_avatar, $user_id_edit)) {
        		$user->redirect('edit-user.php?userUpdated');
        	}
	  	} 
	}

	include '../partials/header.php';
	include '../partials/nav.php';

?>
<form method="POST">
	<div class="container-fluid edit-user">
	    <?php if(isset($error)) { foreach($error as $error) { ?>
	      <div class="row">
	        <div class="alert alert-danger col-xs-12">
	          <a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
	          <i class="glyphicon glyphicon-warning-sign"></i><?php echo $error; ?>
	        </div>
	      </div>
	    <?php }} else if(isset($_GET['userUpdated'])) { ?>
	      <div class="row">
	        <div class="alert alert-info">
	          <a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
	          <i class="fa fa-bell"></i> User information updated! <a href='home.php'>Back to home</a>
	        </div>
	      </div>        
	    <?php } ?>
	    <div class="panel mb0 row">
	      <div class="panel-heading col-xs-12">
	        <h5 class="panel-title text-left">
	          Edit user
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
	        <input type="text" class="form-control" name="update_firstname" placeholder="First name" value="<?= $editUserInfo['user_firstname'] ?>" />
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
	        <input type="text" class="form-control" name="update_lastname" placeholder="Last name" value="<?= $editUserInfo['user_lastname'] ?>" />
	      </div>
	    </div>
	    <div class="panel mb0 row">
	      <div class="panel-heading subheading col-xs-12">
	        <p class="panel-title subtitle text-left">
	          Email
	        </p>
	      </div>
	    </div>
	    <div class="panel-content row">
	      <div class="input-group col-xs-12">
	        <input type="email" class="form-control" name="update_email" placeholder="Email" value="<?= $editUserInfo['user_email'] ?>" />
	      </div>
	    </div>
	    <div class="panel mb0 row">
	      <div class="panel-heading subheading col-xs-12">
	        <p class="panel-title subtitle text-left">
	          Department
	        </p>
	      </div>
	    </div>
	    <div class="panel-content row">
	      <div class="input-group col-xs-12">
	        <input type="text" class="form-control" name="update_department" placeholder="Department" value="<?= $editUserInfo['department_name'] ?>" disabled/>
	      </div>
	    </div>
	    <div class="panel mb0 row">
	      <div class="panel-heading subheading col-xs-12">
	        <p class="panel-title subtitle text-left">
	          Password <small></small>
	        </p>
	      </div>
	    </div>
	    <div class="panel-content row">
	      <div class="input-group col-xs-12">
	        <input type="password" class="form-control" name="update_password" placeholder="******" disabled />
	      </div>
	    </div>
		<div class="panel mb0 row">
      <div class="panel-heading subheading col-xs-12">
        <p class="panel-title subtitle text-left">
        	Avatar
        </p>
      </div>
    </div>
    <div class="panel-content row">
      <div class="input-group col-xs-12">
        <img src="<?= $assetsImg . "/avatars/" . $editUserInfo['avatar_url']; ?>" alt="<?= "profile-" . $editUserInfo['user_firstname'] ?>" />
        <div class="input-group col-xs-12">
	        <div class="radio choose-avatar">
	          <?php foreach ($displayAvatars as $row): ?>
	            <div class="col-xs-3">
	              <input type="radio" name="update_avatar" id="avatar-<?= $row['avatar_id'];?>" value="<?= $row['avatar_id']; ?>">
	              <label class="avatar-cc avatar-<?= $row['avatar_id'];?>" for="avatar-<?= $row['avatar_id'];?>"></label>
	            </div>
	          <?php endforeach; ?>
	        </div>
      	</div>
      </div>
    </div>
    <div class="row">
    	<button type="submit" class="btn btn-create btn-block btn-primary" name="btn-updateUser">
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

<?php include '../partials/footer.php'; ?>