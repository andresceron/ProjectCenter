<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';

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
			if($projects->updateProj($btnStatus, $proj_id)) {
				$user->redirect('project-detail.php?StatusUpdated');
			}
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
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
					</div>
				<?php endif ?>
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
				<button type="button" class="btn btn-md btn-info" name="">Edit</button>
			</div>
			<div class="col-md-4">
			<div class="project-team">
				<h4>The Team</h4>
				<?php foreach ($allUsersProj as $row): ?>
					<p><?= $row['user_firstname'] . " " . $row['user_lastname']; ?></p>
				<?php endforeach ?>
			</div>

				<div class="row">
					<form method="POST">
						<div class="form-group">
							<input type="submit" class="btn btn-lg btn-primary" name="btn-status" value="Active" />
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-lg btn-success" name="btn-status" value="Done" />
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-lg btn-warning" name="btn-status" value="Upcoming" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php include '../partials/footer.php'; ?>