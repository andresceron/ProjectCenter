<?php

	// Users ID
	$user_id           = isset($_SESSION['user_session']);     	
	// User variables 
	$allUsers          = $user->allUsers($user_id);
	$userInfo          = $user->userData($user_id);
	$usertypeName      = $user->userTypeName($user_id);
	$usertype          = $user->userType($user_id);
	$departments       = $user->department_name();
	$displayAvatars    = $user->display_avatars();

	// Projects variables
	$allProjects       = $projects->allProjects();
	$upcomingProjects  = $projects->upcomingProjects($user_id);
	$previousProjects  = $projects->previousProjects($user_id);
	$activeProjects    = $projects->activeProjects($user_id);
	$userProjects      = $projects->userProjects($user_id);

	// Common Assets variables
	$assetsImg         = $variables->getAssetsImg();
	$assetsJs          = $variables->getAssetsJS();
	$assetsCss         = $variables->getAssetsCSS();