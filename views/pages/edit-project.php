<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';
	//$proj_id = $_SESSION['proj_id'];
	$proj_id = $_GET['projId'];
	$singleProjectsRow = $projects->singleProject($proj_id);

	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}

	if(isset($_POST['btn-updateProj'])) {
		$proj_name       = $_POST['proj_name'];
		$proj_desc       = $_POST['proj_desc'];
		$proj_date_start = $_POST['proj_date_start'];
		$proj_date_end   = $_POST['proj_date_end'];


		if (empty($proj_name)) {
			$error[] = "Please provide a project name for this project!"; 
		} elseif(strlen($proj_name) < 7) {
			$error[] = "Project name has to be at least 7 character long"; 
		} elseif (empty($proj_desc)) {
			$error[] = "Please provide a description for this project!"; 
		} elseif(strlen($proj_desc) < 15) {
			$error[] = "Project description has to be at least 15 character long"; 
		} elseif (empty($proj_date_start)) {
			$error[] = "Please provide an start date for this project!"; 
		} elseif (empty($proj_date_end)) {
			$error[] = "Please provide an end date for this project!"; 
		} elseif ($proj_date_start > $proj_date_end) {
			$error[] = "The end date must be set AFTER the start date";
		} else {
			try {
				if($projects->updateProj($proj_name, $proj_desc, $proj_date_start, $proj_date_end, $proj_id)) {
					$user->redirect('project-detail.php?showProj='.$proj_id.'&ProjectUpdated');
				}
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	} elseif (isset($_POST['btn-deleteProj'])) {
		if($projects->deleteProj($proj_id)) {
			$user->redirect('home.php?projectDeleted='.$proj_id.'');
		}
	}


	include '../partials/header.php';
	include '../partials/nav.php';
?>

	<div class="container content">
		<div class="row">
			<div class="col-md-8">
			<?php if(isset($error)) { foreach($error as $error) { ?>
				<div class="alert alert-danger">
					<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
				</div>
			<?php }} ?>
			</div>
			<div class="col-md-8">
				<form method="POST">
					<?php if(isset($_GET['StatusUpdated'])) : ?>
						<div class="alert alert-info">
				 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; Project Status changed to...
				 				<?= ($singleProjectsRow['proj_state'] == 1 ? "Active" : ($singleProjectsRow['proj_state'] == 2 ? 'Done' : 'Upcoming') ); ?>
						</div>
					<?php endif ?>
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
									<label>Project name:</label>
								</div>
								<div class="col-md-8">
									<input type="text" name="proj_name" value="<?= $singleProjectsRow['proj_name']; ?>" />
								</div>
								<br><hr>
								<div class="col-md-4">
									<label>Project description:</label>
								</div>
								<div class="col-md-8">
									<input type="text" name="proj_desc" value="<?= $singleProjectsRow['proj_desc']; ?>" />
								</div>
								<br><hr>
								<div class="col-md-4">
									<label>Project Start date:</label>
								</div>
								<div class="col-md-8">
									<input type="date" name="proj_date_start" value="<?= $singleProjectsRow['proj_date_start']; ?>" />
								</div>
								<br><hr>
								<div class="col-md-4">
									<label>Project End date:</label>
								</div>
								<div class="col-md-8">
									<input type="date" name="proj_date_end" value="<?= $singleProjectsRow['proj_date_end']; ?>" />
								</div>
								<br>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<input type="submit" class="btn btn-md btn-info" name="btn-updateProj" value="Update Project"/>
						</div>
						<div class="col-md-3">
							<input type="submit" class="btn btn-md btn-danger" name="btn-deleteProj" value="Delete Project"/>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-4">
			</div>
		</div>
	</div>
<?php include '../partials/footer.php'; ?>