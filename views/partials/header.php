<?php $homePage = "home.php"; ?>
<!DOCTYPE html>
<html lang="SV-se">
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="Andres Ceron">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1.0, minimum-scale=1.0, maximum-scale=1.0">
	
		<!-- build:css assets/scripts/vendors.min.css -->
		<link href="/bower_components/font-awesome-4.2.0/css/font-awesome.min.css">
		<link href="/bower_components/normalize.css/normalize.css">
		<!-- /build -->

	    <!-- build:css assets/styles/main.min.css -->
		<!-- <link rel="stylesheet" href="<?= $variables->getAssetsCSS(); ?>/main.css">	     -->
		<link rel="stylesheet" href="<?= $variables->getAssetsCSS(); ?>/main.css">	    
	    <!-- /build -->

		<title>Project Center - Manager</title>
	</head>
	<body class="<?= !$homePage ? "login" : "home"; ?>">