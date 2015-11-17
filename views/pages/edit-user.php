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
<div class="container content">
	<div class="row">
		<div class="col-md-12">
            <?php if(isset($error)) :
        		foreach($error as $error) : ?>
		          	<div class="alert alert-danger">
		              	<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
		          	</div>
        		<?php endforeach;
				elseif(isset($_GET['userUpdated'])): ?>
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
						  <input type="text" class="form-control" name="update_firstname" placeholder="First name" value="<?= $editUserInfo['user_firstname'] ?>" />
						</div>
						<div class="form-group">
						  <input type="text" class="form-control" name="update_lastname" placeholder="Last name" value="<?= $editUserInfo['user_lastname'] ?>" />
						</div>
						<div class="form-group">
						  <input type="email" class="form-control" name="update_email" placeholder="Email" value="<?= $editUserInfo['user_email'] ?>" />
						</div>
						<div class="form-group">
						  <input type="text" class="form-control" name="update_department" placeholder="Department" value="<?= $editUserInfo['department_name'] ?>" disabled/>
						</div>

						<div class="form-group">
						  <input type="password" class="form-control" name="update_password" placeholder="******" disabled />
						</div>
						<div class="form-group">
							<p><b>Current Avatar:</b></p>
							<div class="profilePicture">
								<img src="<?= $assetsImg . "/avatars/" . $editUserInfo['avatar_url']; ?>" alt="<?= "profile-" . $editUserInfo['user_firstname'] ?>" />
					    	</div><br />
					    	<p>Choose a new avatar:</p>
						  	<div class="radio">
						  		<div class="row">
						  			<?php foreach ($displayAvatars as $row): ?>
					  				<div class="col-md-2">
								      	<label>
								        	<img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" alt="" width="100px" class="img-thumbnail" />
								        	<input type="radio" name="update_avatar" value="<?= $row['avatar_id']; ?>">
								    	</label>
							    	</div>
							    	<?php endforeach; ?>	
						  			
						  		</div>
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