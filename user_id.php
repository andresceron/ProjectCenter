<?php
	
	// User variables 
	$user_id = $_SESSION['user_session'];	
	$userInfo = $user->userData($user_id);
	$usertype = $user->userType($user_id);

	// Projects variables
	$allProjects = $user->allProjects();

	
	


	// if ($usertype == "1") {
	// 	$usertype = "Admin";
	// } elseif ($usertype == "2") {
	// 	$usertype = "User"; 
	// } elseif (empty($userInfo)) {
	// 	$usertype = "Not assigned";
	// }

	// Common Assets variables
	$assetsImg = $variables->getAssetsImg();
	$assetsJs = $variables->getAssetsJS();
	$assetsCss = $variables->getAssetsCSS();