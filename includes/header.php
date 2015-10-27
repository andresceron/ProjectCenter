<?php 
$homePage = "home.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>Project Center - Manager</title>
</head>

<body>
	<nav class="navbar bg-primary">
		<div class="container-fluid">
		    <div class="navbar-header">
				<a class="navbar-brand color-white" href="#">
		        <!-- <img alt="Brand" src="..."> -->
		        <label>Project Manager</label>
		      	</a>
		    </div>
		    <div class="pull-right">
		    	<?php if ($user->curPageName() == $homePage): ?>
					<a href="logout.php?logout=true" class="btn btn-danger navbar-btn"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
				<?php else: ?>
					<a href="home.php" class="btn btn-info navbar-btn"><i class=""></i> Back to home</a> 
					<a href="logout.php?logout=true" class="btn btn-danger navbar-btn"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
				<?php endif; ?>
			</div>
		</div>
	</nav> 