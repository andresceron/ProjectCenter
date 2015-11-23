<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	
	if($_SESSION['user_session']!="") {
		$user->redirect('/projectCenter/views/pages/home.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true") {
		$user->logout();
		$user->redirect('/ProjectCenter/index.php?loggedOut');
	}
	// if(!isset($_SESSION['user_session'])) {
	// 	$user->redirect('http://localhost:8888/projectCenter/index.php');
	// } 