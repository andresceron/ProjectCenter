<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	
	if($_SESSION['user_session']!="") {
		$user->redirect('home.php');
	}

	if(isset($_GET['logout']) && $_GET['logout']=="true") {
		$user->logout();
		$user->redirect('/index.php?loggedOut');
	}