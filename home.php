<?php
	include_once 'dbconfig.php';
	session_start();

	if(!$user->is_loggedin()) { // If no user redirect to index.php
		$user->redirect('index.php');
	} else {
		$user->timestamp();
	}
	//on session creation
	$user_id = $_SESSION['user_session'];


	$stmt = $DB_con->prepare("SELECT * FROM tbl_users WHERE user_id = :user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$user=$stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css" type="text/css"  />
	<title>HOME</title>	
</head>

<body>

<div class="header">
    <div class="right">
    	<label><a href="logout.php?logout=true"><i class="glyphicon glyphicon-log-out"></i> logout</a></label>
    </div>
</div>
<div class="content">
<h1>Welcome</h1>
<p><?= $user['user_name']; ?></p>
<p><?= $user['user_email']; ?></p>
</div>
</body>
</html>