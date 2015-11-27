<aside class="panel sidebar">
	<div class="container-fluid none">
		<div class="row">
			<div class="panel-heading col-xs-12">
				<div class="profile text-center">
					<form method="POST" action="home.php">
						<label class="mt5 border-bottom">
							<img src="<?= $assetsImg . "/avatars/" . $userInfo['avatar_url']; ?>" alt="<?= "profile-" . $userInfo['user_firstname'] ?>" />
							<input type="hidden" name="user_id_edit" value="<?= $userInfo['user_id']; ?>">
							<button type="submit" class="btn-transparent mb10" name="editUser">
								<p class="ellipsis mt10 mb5"><?= $userInfo['user_firstname'] . " " . $userInfo['user_lastname'];?></p>	
								<span class="ellipsis"><?= $userInfo['department_name'];?></span>	
							</button>
						</label>
					</form>
				</div>		
			</div>
		</div>	
	</div>
		<?php if($usertype == 1) : ?>
			<a href="create-project.php" class="btn btn-links btn-blue btn-block">Create new project</a> 
			<a href="sign-up.php" class="btn btn-links btn-green btn-block">Add new user</a>
		<?php endif; ?>
		<a href="management.php" class="btn btn-links btn-yellow btn-block">User Center</a>
		<?php if ($variables->curPageName() != $homePage): ?>
			<hr class="height-space">
			<a href="home.php" class="btn btn-links btn-brown btn-block">Back to home</a> 
		<?php endif; ?>
		<hr class="height-space">
		<a href="logout.php?logout=true" class="btn btn-danger btn-md btn-block btn-links btn-logout">Logout</a>
</aside>
