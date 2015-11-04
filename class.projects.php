<?php 

	if(isset($_POST['projectDetail'])) {
		try {
			$_SESSION['proj_id'] = $row['proj_id'];
			$query = "SELECT * FROM tbl_projects WHERE proj_id = :proj_id";
			$stmt = $DB_con->prepare($query);
			$stmt->execute(array(':proj_id' => $proj_id));
			$projDetailRow = $stmt->fetch(PDO::FETCH_ASSOC);

		 //   	$query = "SELECT * FROM tbl_users AS u ";
		 //    $query .= "LEFT JOIN tbl_departments AS d ON u.user_department = d.department_id ";
		 //    $query .= "WHERE user_id = :user_id";
		 //    $stmt = $DB_con->prepare($query);
		 //    $stmt->execute(array(":user_id" => $user_id));
		 //    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			// // Fetch ALL PROJECTS
		 //    $query = 'SELECT * FROM tbl_projects WHERE proj_id = :proj_id';
		 //    $stmt = $DB_con->prepare($query);
		 //    $stmt->execute();
		 //    $allProjectsRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
		 
		 // 	$user_id = $_SESSION['user_session'];	
		// $stmt = $DB_con->prepare("SELECT * FROM tbl_users WHERE user_id = :user_id");
		// $stmt->execute(array(":user_id" => $user_id));
		// $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

?>