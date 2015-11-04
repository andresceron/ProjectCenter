<?php
	$user_id = $_SESSION['user_session'];	
	
	$stmt = $DB_con->prepare("SELECT * FROM tbl_users WHERE user_id = :user_id");
	$stmt->execute(array(":user_id" => $user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
