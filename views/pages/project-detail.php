<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';
	//$proj_id = $_SESSION['proj_id'];
	$proj_id = $_GET['showProj'];
	$singleProjectsRow = $projects->singleProject($proj_id);
	$singleProjectsTasks = $projects->singleProjectTasks($proj_id);
	$allUsersProj      = $projects->allUsersProj($proj_id);

	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}

	if(isset($_POST['btn-status'])) {
		$btnStatus = $_POST['btn-status'];
 
		if ($btnStatus == "Done") {
			$btnStatus = "2";
		} elseif ($btnStatus == "Active" ) {
			$btnStatus = "1";
		} elseif ($btnStatus == "Upcoming") {
			$btnStatus = "0";
		}
		try {
			if($projects->updateProjStatus($btnStatus, $proj_id)) {
				$user->redirect('project-detail.php?showProj='.$proj_id.'&StatusUpdated');
			}
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	} elseif (isset($_POST['btn-editProj'])) {
		$user->redirect('edit-project.php?projId='.$proj_id.'');
	}

	include '../partials/header.php';
	include '../partials/nav.php';
?>

	<div class="container content">
		<div class="row">
			<div class="col-md-8">
				<?php if(isset($_GET['StatusUpdated'])) : ?>
					<div class="alert alert-info">
			 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; Project Status changed to...
			 				<?= ($singleProjectsRow['proj_state'] == 1 ? "Active" : ($singleProjectsRow['proj_state'] == 2 ? 'Done' : 'Upcoming') ); ?>
					</div>
				<?php elseif(isset($_GET['ProjectUpdated'])) : ?>
					<div class="alert alert-info">
	 					<i class="glyphicon glyphicon-log-in"></i> &nbsp; Project Updated!
					</div>
				<?php endif; ?>
				<div class="panel panel-default">
				<?= $proj_id; ?>
					<div class="panel-heading">Project Details
						<p> Status: 
							<?= ($singleProjectsRow['proj_state'] == 1 ? "Active" : ($singleProjectsRow['proj_state'] == 2 ? 'Finished' : 'Upcoming') ); ?>
						</p>
					</div>
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
				<div class="row">
					<form method="POST">
						<div class="col-md-3">
							<input type="submit" class="btn btn-lg btn-primary" name="btn-status" value="Active" />
						</div>
						<div class="col-md-3">
							<input type="submit" class="btn btn-lg btn-success" name="btn-status" value="Done" />
						</div>
						<div class="col-md-3">
							<input type="submit" class="btn btn-lg btn-warning" name="btn-status" value="Upcoming" />
						</div>
						<div class="col-md-3">
							<input type="submit" class="btn btn-md btn-info" name="btn-editProj" value="Edit" />
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-4">
				<div class="project-team">
					<h4>The Team</h4>
					<?php if ($allUsersProj === false): ?>
						<p>No users</p>
					<?php else: foreach ($allUsersProj as $row): ?>
						<div>
							<img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" width="100px" />
							<span><?= $row['user_firstname'] . " " . $row['user_lastname']; ?></span>
						</div>

					<?php endforeach; endif; ?>
				</div>
				<br/>
				<div class="tasklist">
					<h4>Task Lists</h4>
					<?php if ($singleProjectsTasks === false): ?>
						<p>No tasks</p>
					<?php else: foreach ($singleProjectsTasks as $row): ?>
							* <span><?= $row['todo_task']; ?></span>

					<?php endforeach; endif; ?>
				</div>

			</div>
		</div>
	</div>
<?php include '../partials/footer.php'; ?>