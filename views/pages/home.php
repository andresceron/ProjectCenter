<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}

	// Fetch my department
   	$query = "SELECT * FROM tbl_users AS u ";
    $query .= "LEFT JOIN tbl_departments AS d ON u.user_department = d.department_id ";
    $query .= "WHERE user_id = ?";
    $stmt = $DB_con->prepare($query);
    $stmt->execute(array($user_id));
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch selected PROJECT and redirect to..
    if (isset($_POST['projectDetail'])) {
	    $_SESSION['proj_id'] = $_POST['proj_id'];
        header('location: project-detail.php');
    }

	//	$query = 'SELECT proj_id, proj_name FROM tbl_projects';
	//	$stmt = $DB_con->prepare($query);
	//	$stmt->execute();
	//	$allProjectsRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Testing with timestamp fetch projects

	// $user->department_name();

	include '../partials/header.php';
	include '../partials/nav.php';
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
					<div class="panel-heading">My Active Projects</div>
					<div class="panel-body">
						<?php //TODO: Generate the active projects ?>
						<div class="list-group">
							<div class="project-lists">
								<?php $projRows = $user->activeProjects($user_id); ?>
								<?php if ($projRows === false): ?>
									<span>No active projects</span>
								<?php else: ?>
									<?php foreach ($projRows as $row): ?>
										<form method="post" action="home.php">
										<button name="projectDetail"><?= $row['proj_name']; ?>
											<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
										</button>
										<span><?= $row['proj_date_start'] ?></span>
										<hr>
										</form>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
				  	</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Upcoming Projects</div>
					<div class="panel-body">
						<?php //TODO: Generate the previous projects ?>
						<div class="list-group">
							<div class="project-lists">
								<?php $projRows = $user->upcomingProjects($user_id); ?>
								<?php if ($projRows === false): ?>
									<span>No upcoming projects yet</span>
								<?php else: ?>
									<?php foreach ($projRows as $row): ?>
										<form method="post" action="home.php">
										<button name="projectDetail"><?= $row['proj_name']; ?>
											<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
										</button>
										<span><?= $row['proj_date_start'] ?></span>
										<hr>
										</form>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
				  	</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Previous Projects</div>
					<div class="panel-body">
						<?php //TODO: Generate the previous projects ?> 
						<div class="list-group">
							<div class="project-lists">
								<?php $projRows = $user->previousProjects($user_id); ?>	
								<?php foreach ($projRows as $row): ?>	
									<form method="post" action="home.php">
										<button name="projectDetail"><?= $row['proj_name']; ?>
											<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
										</button>
										<span><?= $row['proj_date_start'] . " - " . $row['proj_date_end'] ?></span>
										<hr>
									</form>	
								<?php endforeach;?>
							</div>
						</div>
				  	</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">All Projects</div>
					<div class="panel-body">
						<?php //TODO: Generate the previous projects ?>
						<div class="list-group">
							<div class="project-lists">
								<?php $variable = $user->allProjects(); ?>
								<?php foreach ($variable as $row): ?>	
									<form method="post" action="home.php">
									<button name="projectDetail"><?= $row['proj_name']; ?>
										<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
									</button>
									<hr>
									</form>
								<?php endforeach;?>
							</div>
						</div>
				  	</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php include '../partials/sidebar.php'; ?>
			</div>
		</div>
	</div>
<?php include '../partials/footer.php'; ?>