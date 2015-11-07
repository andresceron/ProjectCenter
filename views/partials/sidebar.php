<div class="panel panel-default">
	<div class="panel-heading">
		<span>My info</span>
	</div>
	<div class="panel-body">
		<div class="col-md-12">
			<?php // @TODO: Fix button to EDIT and CREATE EDIT page and functions ?>
			<button class="pull-right">Edit info</button>	
		</div>
		<div class="profilePicture">
			<?php if(false): ?>
				<img src="<?= $assetsImg; ?>/profiles/profile-demo.jpg" alt="<?= "profile-" . $userInfo['user_firstname'] ?>">			
			<?php else: ?>
    			<img src="<?= $assetsImg; ?>/profiles/default-pic.png" alt="<?= "profile-" . $userInfo['user_firstname']?>">		
    		<?php endif; ?>
    	</div>
  	</div>
	<table class="table">
		<tr>
			<td>Name:</td>
			<td><?= $userInfo['user_firstname'] . " " . $userInfo['user_lastname'];?></td>
		</tr>
		<tr>
			<td>Department:</td>
			<td><?= $userInfo['department_name']; ?></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><?= $userInfo['user_email']; ?></td>
		</tr>
	</table>
</div>
<a href="create-project.php" class="btn btn-primary btn-md btn-block">Create new project</a> 