<?php

	// Users ID
	$user_id           = isset($_SESSION['user_session']);     	
	// User variables 
	$userInfo          = $user->userData($user_id);
	$usertypeName      = $user->userTypeName($user_id);
	$usertype          = $user->userType($user_id);
	$departments       = $user->department_name();
	$displayAvatars    = $user->display_avatars();

	// Single Projects ID
	$proj_id           = $_SESSION['proj_id'];

	// Projects variables
	$singleProjectsRow = $projects->singleProject($proj_id);
	$allUsersProj      = $projects->allUsersProj($proj_id);
	$allProjects       = $projects->allProjects();
	$upcomingProjects  = $projects->upcomingProjects($user_id);
	$previousProjects  = $projects->previousProjects($user_id);
	$activeProjects    = $projects->activeProjects($user_id);
	$userProjects      = $projects->userProjects($user_id);

	// Common Assets variables
	$assetsImg         = $variables->getAssetsImg();
	$assetsJs          = $variables->getAssetsJS();
	$assetsCss         = $variables->getAssetsCSS();