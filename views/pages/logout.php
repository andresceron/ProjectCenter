<?php
	require_once '../../dbconfig.php';
	
	if($_SESSION['user_session']!="") {
		$user->redirect('http://localhost:8888/projectCenter/views/pages/home.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true") {
		$user->logout();
		$user->redirect('index.php');
	}
	if(!isset($_SESSION['user_session'])) {
		$user->redirect('http://localhost:8888/projectCenter/index.php');
	} 