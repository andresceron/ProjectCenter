<div class="panel panel-default">
	<div class="panel-heading">
		<span>My info</span>
	</div>
	<div class="panel-body">
		<div class="col-md-12">
			<?php // @TODO: Fix button to EDIT and CREATE EDIT page and functions ?>
			<a href="../pages/edit-user.php" class="btn btn-xs btn-info pull-right" name="editUser">Edit info</a>
		</div>
		<div class="profilePicture">
			<img src="<?= $assetsImg . "/avatars/" . $userInfo['avatar_url']; ?>" alt="<?= "profile-" . $userInfo['user_firstname'] ?>" />
    	</div>
  	</div>
	<table class="table">
		<tr>
			<td>Name:</td>
			<td><?= $userInfo['user_firstname'] . " " . $userInfo['user_lastname'];?></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><?= $userInfo['user_email']; ?></td>
		</tr>
		<tr>
			<td>Department:</td>
			<td><?= $userInfo['department_name']; ?></td>
		</tr>
	</table>
</div>
<a href="create-project.php" class="btn btn-primary btn-md btn-block">Create new project</a> 