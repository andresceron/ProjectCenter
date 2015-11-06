
<nav class="navbar bg-primary">
	<div class="container-fluid">
	    <div class="navbar-header">
			<a class="navbar-brand color-white" href="#">
	        <!-- <img alt="Brand" src="..."> -->
	        <label>Project Manager</label> -
	        <span>Logged in as: <?= $userInfo['user_usertype']; ?></span> | <span><?= $usertype ?></span>
	      	</a>
	    </div>
	    <div class="pull-right">
	    	<?php if ($user->curPageName() != $homePage): ?>
				<a href="home.php" class="btn btn-info navbar-btn"><i class=""></i> Back to home</a> 
			<?php endif; ?>
			<a href="logout.php?logout=true" class="btn btn-danger navbar-btn"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
			<a href="settings.php" class="fa fa-cog"></a>
		</div>
	</div>
</nav> 