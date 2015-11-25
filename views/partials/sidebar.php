<aside class="panel sidebar">
	<div class="container-fluid">
		<div class="row">
			<div class="panel-heading col-xs-12">
				<div class="profile text-center">
					<form method="POST" action="home.php">
						<label class="mt5">
							<img src="<?= $assetsImg . "/avatars/" . $userInfo['avatar_url']; ?>" alt="<?= "profile-" . $userInfo['user_firstname'] ?>" />
							<input type="hidden" name="user_id_edit" value="<?= $userInfo['user_id']; ?>">
							<button type="submit" class="btn-transparent" name="editUser">
								<p class="ellipsis mt10 mb5"><?= $userInfo['user_firstname'] . " " . $userInfo['user_lastname'];?></p>	
								<span class="ellipsis"><?= $userInfo['department_name'];?></span>	
							</button>
						</label>
					</form>
				</div>		
			</div>
		</div>	
	</div>
		<a href="create-project.php" class="btn btn-sidebar btn-primary btn-block">Create new project</a> 
		<a href="sign-up.php" class="btn btn-sidebar btn-success btn-block"><i class=""></i> New user</a>
		<a href="management.php" class="btn btn-sidebar btn-warning btn-block">Management</a>
		<a href="logout.php?logout=true" class="btn btn-danger btn-md btn-block"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
</aside>

		  	<!-- <div class="table-responsive">
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
			</div> -->