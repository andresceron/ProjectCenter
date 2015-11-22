<aside class="panel">
	<div class="container-fluid">
		<div class="row mb5">
			<div class="panel-heading col-xs-12">
				<div class="profile">
<!-- 					<div class="row">
						<div class="col-xs-3"> -->
							<img src="<?= $assetsImg . "/avatars/" . $userInfo['avatar_url']; ?>" alt="<?= "profile-" . $userInfo['user_firstname'] ?>" />
<!-- 						</div> -->
						<!-- <div class="col-xs-9"> -->
							<form method="POST">
								<input type="hidden" name="user_id_edit" value="<?= $userInfo['user_id']; ?>">
								<button type="submit" class="btn-transparent" name="editUser">
									<p class="ellipsis"><?= $userInfo['user_firstname'] . " " . $userInfo['user_lastname'];?></p>	
								</button>
							</form>
						<!-- </div> -->
					<!-- </div> -->
				</div>		
			</div>
		</div>
		<div class="profile">
			<div class="row">
				<div class="col-xs-3">
					<img src="<?= $assetsImg . "/avatars/" . $userInfo['avatar_url']; ?>" alt="<?= "profile-" . $userInfo['user_firstname'] ?>" />
				</div>
				<div class="col-xs-9">
					<form method="POST">
						<input type="hidden" name="user_id_edit" value="<?= $userInfo['user_id']; ?>">
						<button type="submit" class="btn-transparent" name="editUser">
							<p class="ellipsis"><?= $userInfo['user_firstname'] . " " . $userInfo['user_lastname'];?></p>	
						</button>
					</form>
				</div>
			</div>
		</div>		
	</div>
		<a href="create-project.php" class="btn btn-primary btn-md btn-block">Create new project</a> 
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