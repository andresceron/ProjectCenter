<nav class="navbar primary-color">
    <div class="navbar-header">
		<a class="navbar-brand mt5" href="/ProjectCenter/views/pages/home.php">
            <?php // <img alt="Brand" src="..."> ?>
            <label>PROJECT CENTER</label>
      	</a>
	    <button type="button" class="navbar-toggle">
	    	<i class="fa fa-bars"></i>
	    </button>	 
    </div>
	<div class="slide-menu">
    	<?php include '../partials/sidebar.php'; ?>
    </div>
</nav>

<?php 


/*

<span>Logged in as: <?= $userInfo['user_usertype']; ?></span> 

<?php if ($variables->curPageName() != $homePage): ?>
	<a href="home.php" class="btn btn-info navbar-btn"><i class=""></i> Back to home</a> 
<?php endif; ?>


<a href="logout.php?logout=true" class="btn btn-danger navbar-btn"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
<a href="management.php" class="fa fa-cog"></a>

*/

?>