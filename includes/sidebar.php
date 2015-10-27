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
    		<img src="https://s3.amazonaws.com/uifaces/faces/twitter/_everaldo/128.jpg" alt="<?= $userRow['user_firstname']?>">
    	</div>
  	</div>
	<table class="table">
		<tr>
			<td>Name:</td>
			<td><?= $userRow['user_firstname'] . " " . $userRow['user_lastname'];?></td>
		</tr>
		<tr>
			<td>Department:</td>
			<td><?= $userRow['department_name']; ?></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><?= $userRow['user_email']; ?></td>
		</tr>
	</table>
</div>
<a href="create-project.php" class="btn btn-primary btn-md btn-block">Create new project</a> 