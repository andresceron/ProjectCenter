<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('../../index.php');
	}

	include '../partials/header.php';
	include '../partials/nav.php';


	print_r($user->department_names());
	die;

	if(isset($_POST['btn-updateUser'])) {


	   	// if(empty($update_firstname)) {
	    // 	$error[] = "provide a first name!"; 
	   	// } else if(empty($update_lastname)) {
	    //  	$error[] = "provide a last name!"; 
	   	// } else if(empty($update_email)) {
	    //   	$error[] = "provide email!"; 
	   	// } else if(filter_var($update_email, FILTER_VALIDATE_EMAIL)) {
	    //   	$error[] = 'Please enter a valid email address!';
	   	// } else {
        		if($user->update_proj($user_id)) {
                	//$user->redirect('edit-user.php?userUpdated');
                	echo "HEJ";
            	}
	  	// } 

	  	// echo $update_firstname;
	  	// echo $update_lastname;
	  	// echo $update_email;
	  	// echo $update_avatar;
	}

?>
<div class="container content">
	<div class="row">
		<div class="col-md-12">
		<?php if(isset($_GET['userUpdated'])): ?>
			<div class="alert alert-success alert-fadeout">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<p>User information updated!</p>
			</div>
		<?php endif; ?>
		</div>
		<form method="POST">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
						  <input type="text" class="form-control" name="update_firstname" placeholder="First name" value="<?= $userInfo['user_firstname'] ?>" />
						</div>
						<div class="form-group">
						  <input type="text" class="form-control" name="update_lastname" placeholder="Last name" value="<?= $userInfo['user_lastname'] ?>" />
						</div>
						<div class="form-group">
						  <input type="email" class="form-control" name="update_email" placeholder="Email" value="<?= $userInfo['user_email'] ?>" />
						</div>
						<div class="form-group">
						  <input type="text" class="form-control" name="update_department" placeholder="Department" value="<?= $userInfo['department_name'] ?>" disabled/>
						</div>

						<div class="form-group">
						  <input type="password" class="form-control" name="update_password" placeholder="******" disabled />
						</div>
						<div class="form-group">
							<p><b>Current Avatar:</b></p>
							<div class="profilePicture">
								<img src="<?= $assetsImg . "/avatars/" . $userInfo['avatar_url']; ?>" alt="<?= "profile-" . $userInfo['user_firstname'] ?>" />
					    	</div><br />
					    	<p>Choose a new avatar:</p>
						  	<div class="radio">
							    <?php foreach ($displayAvatars as $row): ?>
							      <label>
							        <img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" alt="" width="140px" class="img-thumbnail" />
							        <input type="radio" name="update_avatar" value="<?= $row['avatar_id']; ?>">
							      </label>
							    <?php endforeach; ?>
						  	</div>
						</div>
						<div class="clearfix"></div><hr />
						<div class="form-group">
						 <button type="submit" class="btn btn-block btn-primary" name="btn-updateUser">
						     <i class="glyphicon glyphicon-open-file"></i>&nbsp;UPDATE USER
						    </button>
						</div>    
					</div>
				</div>
            </div>
		</form>
	</div>
</div>