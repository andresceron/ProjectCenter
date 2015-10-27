<?php
	include_once 'dbconfig.php';
	require_once 'user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}

   	$query = "SELECT * FROM tbl_users AS u ";
    $query .= "LEFT JOIN tbl_departments AS d ON u.user_department = d.department_id ";
    $query .= "WHERE user_id = :user_id";
    $stmt = $DB_con->prepare($query);
    $stmt->execute(array(":user_id" => $user_id));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
 
$user->department_name();

include 'includes/header.php';
?>
	<div class="container content">
		<div class="row">
			<div class="col-md-12">
			<?php if(isset($_GET['userLoggedIn'])): ?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Welcome: <?= $userRow['user_firstname'] . " " . $userRow['user_lastname']?> If you need any support, write to support@support.com	
				</div>
				
			<?php endif; ?>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">Active Projects</div>
					<div class="panel-body">
						<?php //TODO: Generate the active projects
						if (false) : ?>
						<div class="list-group">
							<div class="project-lists">
								<a href="#" class="unlisted-group">First project</a>
								<hr>
								<a href="#" class="unlisted-group">Second project</a>
								<hr>
								<a href="#" class="unlisted-group">Third project</a>
							</div>
						</div>
					<?php else : ?>
						<a href="create-project.php" class="btn btn-primary btn-md">Create new project</a>
			    	<?php endif; ?>
				  	</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Upcoming Projects</div>
					<div class="panel-body">
						<?php //TODO: Generate the active projects
						if (false) : ?>
						<div class="list-group">
							<div class="project-lists">
								<a href="#" class="unlisted-group">First project</a>
								<hr>
								<a href="#" class="unlisted-group">Second project</a>
							</div>
						</div>
					<?php else : ?>
			    		<p>No upcoming projects yet</p>
			    	<?php endif; ?>
				  	</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Previous Projects</div>
					<div class="panel-body">
						<?php //TODO: Generate the active projects
						if (false) : ?>
						<div class="list-group">
							<div class="project-lists">
								<a href="#" class="unlisted-group">First project</a>
							</div>
						</div>
					<?php else : ?>
			    		<p>No previous projects yet</p>
			    	<?php endif; ?>
				  	</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php include 'includes/sidebar.php'; ?>
			</div>
		</div>
	</div>
<?php include 'includes/footer.php'; ?>