<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}
	
	$proj_id = $_SESSION['proj_id'];

	// Fetch THIS PROJECTS
    // $query = 'SELECT * FROM tbl_projects WHERE proj_id = :proj_id';
    // $stmt = $DB_con->prepare($query);
    // $stmt->execute(array('proj_id' => $proj_id));
    // $singleProjectsRow = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $singleProjectsRow = $user->singleProject($proj_id);

	include '../partials/header.php';
	include '../partials/nav.php';
?>
	<div class="container content">
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
				<?= $proj_id; ?>
					<div class="panel-heading">Project Details</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">
								Project name:
							</div>
							<div class="col-md-8">
								<?= $singleProjectsRow['proj_name']; ?>
							</div>
							<br><hr>
							<div class="col-md-4">
								Project description:
							</div>
							<div class="col-md-8">
								<?= $singleProjectsRow['proj_desc']; ?>
							</div>
							<br><hr>
							<div class="col-md-4">
								Project Start date:
							</div>
							<div class="col-md-8">
								<?= $singleProjectsRow['proj_date_start']; ?>
							</div>
							<br><hr>
							<div class="col-md-4">
								Project End date:
							</div>
							<div class="col-md-8">
								<?= $singleProjectsRow['proj_date_end']; ?>
							</div>
							<br><hr>
							<div class="col-md-4">
								Departments:
							</div>
							<div class="col-md-8">
								<?= "@TODO" ?>
							</div>
							<br><hr>
						</div>
					</div>
				</div>
				<button class="btn btn-md btn-info" name="">Edit</button>
			</div>
			<div class="col-md-4">
			</div>
		</div>
	</div>
<?php include '../partials/footer.php'; ?>