<?php
	// User variables 
	$user_id          = isset($_SESSION['user_session']);     	
	$userInfo         = $user->userData($user_id);
	$usertypeName     = $user->userTypeName($user_id);
	$usertype         = $user->userType($user_id);

	// Projects variables
	$allProjects      = $user->allProjects();
	$upcomingProjects = $user->upcomingProjects($user_id);
	$previousProjects = $user->previousProjects($user_id);
	$activeProjects   = $user->activeProjects($user_id);
	$userProjects     = $user->userProjects($user_id);
	$departments	  = $user->department_name();
	// Common Assets variables
	$assetsImg        = $variables->getAssetsImg();
	$assetsJs         = $variables->getAssetsJS();
	$assetsCss        = $variables->getAssetsCSS();
