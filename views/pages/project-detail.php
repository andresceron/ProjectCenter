<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';
	//$proj_id = $_SESSION['proj_id'];
	$proj_id             = $_GET['showProj'];
	$singleProjectsRow   = $projects->singleProject($proj_id);
	$singleProjectsTasks = $projects->singleProjectTasks($proj_id);
	$allUsersProj        = $projects->allUsersProj($proj_id);

	$tasksUnchecked      = $projects->tasksUnchecked($proj_id);
	$tasksChecked        = $projects->tasksChecked($proj_id);

	if(!$user->is_loggedin()) {
		$user->redirect('http://localhost:8888/projectCenter/index.php');
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

	} elseif (isset($_POST['btn-CheckTasks'])) {
		if(isset($_POST['proj_tasks'])) {
			$task_id = $_POST['proj_tasks'];
		} else {
			$task_id = "";
		}
		$projects->checkTasks($task_id);
		$user->redirect('project-detail.php?showProj='.$proj_id.'&TasksUpdated');
	}

	include '../partials/header.php';
	include '../partials/nav.php';
?>

<!-- <div class="col-xs-4">
	<p> Status: 
		<?= ($singleProjectsRow['proj_state'] == 1 ? "Active" : ($singleProjectsRow['proj_state'] == 2 ? 'Finished' : 'Upcoming') ); ?>
	</p>	
</div> -->
	<div class="container-fluid">
		<?php if(isset($_GET['TasksUpdated'])): ?>
			<div class="row">
				<div class="alert alert-success alert-fadeout mb0 col-xs-12">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					Tasks updated successfully!
				</div>
			</div>
		<?php endif; ?>
		<div class="panel mb0 row">
			<div class="panel-heading col-xs-12">
				<h5 class="panel-title text-left">
					Project Details
				</h5>
				<form method="POST" class="inline pull-right">
					<button type="submit" class="btn btn-transparent btn-edit" name="btn-editProj" value="Edit">
						<i class="fa fa-pencil"></i>
					</button>
				</form>
			</div>
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Name
				</p>
			</div>
		</div>
		<div class="panel-content row">
			<div class="col-xs-12 pt10">
				<p><?= $singleProjectsRow['proj_name']; ?></p>
			</div>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Description
				</p>
			</div>
		</div>
		<div class="panel-content row">
			<div class="col-xs-12 pt10">
				<p><?= $singleProjectsRow['proj_desc']; ?></p>
			</div>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Date
				</p>
			</div>
		</div>
		<div class="panel-content row">
			<div class="col-xs-6 text-center border-right">
				<p class="mt10"><?= $singleProjectsRow['proj_date_start']; ?></p>
			</div>
			<div class="col-xs-6 text-center">
				<p class="mt10"><?= $singleProjectsRow['proj_date_end']; ?></p>
			</div>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					The Team
				</p>
			</div>
		</div>
		<div class="panel-content project-team row">
			<?php if ($allUsersProj === false): ?>
				<div class="col-xs-12">
					<p class="mt10">No team assigned</p>
				</div>
				<?php else: foreach ($allUsersProj as $row): ?>
				<div class="col-xs-12 pt10 pb10 border-bottom">
					<div class="row">
						<div class="col-xs-3 profile">
							<img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" />
						</div>
						<div class="col-xs-9">
							<p class="mt10 ellipsis"><?= $row['user_firstname'] . " " . $row['user_lastname']; ?></p class="mt10">
						</div>
					</div>
				</div>
			<?php endforeach; endif; ?>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Tasks
				</p>
			</div>
		</div>
		<div class="panel-content tasklist row">
			<?php if ($singleProjectsTasks === false): ?>
				<div class="col-xs-12">
					<p class="mt10">No tasks assignad</p>
				</div>
			<?php else: ?>
				<form method="POST">
					<?php if (!empty($tasksUnchecked)): ?>
						<?php foreach ($tasksUnchecked as $row): ?>
							<div class="checkbox col-xs-12">
							 	<label>
							    	<input type="checkbox" name="proj_tasks[]" value="<?= $row['todo_id']; ?>"><?= $row['todo_task']; ?>
							  	</label>
							</div>	
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if(!empty($tasksChecked)): ?>
						<?php foreach ($tasksChecked as $row): ?>
							<div class="checkbox col-xs-12">
							 	<label>
							    	<input type="checkbox" checked disabled><?= $row['todo_task']; ?>
							  	</label>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
					<button type="submit" name="btn-CheckTasks" class="btn btn-block btn-update">Update tasks</button>
				</form>
			<?php endif; ?>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Status
				</p>
			</div>
		</div>
		<div class="panel-content status border-bottom row">
			<form method="POST">
				<div class="col-xs-4">
					<button type="submit" class="btn btn-full-multi btn-primary" name="btn-status" value="Active">Active</button>
				</div>
				<div class="col-xs-4">
					<button type="submit" class="btn btn-full-multi btn-success" name="btn-status" value="Done">Done</button>
				</div>
				<div class="col-xs-4">
					<button type="submit" class="btn btn-full-multi btn-warning" name="btn-status" value="Upcoming">Upcoming</button>
				</div>
			</form>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<a href="../home.php" class="btn btn-block btn-outline btn-to-home mt15"><i class="fa fa-chevron-left pull-left"></i> Back to home</a>	
			</div>
		</div>			
	</div>
				<!-- <div class="row">
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
						<div class="text-left">
							<img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" width="50px" />
							<span><?= $row['user_firstname'] . " " . $row['user_lastname']; ?></span>
						</div><br/>

					<?php endforeach; endif; ?>
				</div>
				<br/>
				<div class="tasklist">
					<form method="POST">
						<h4>Task Lists</h4>
						<?php if ($singleProjectsTasks === false): ?>
							<p>No tasks</p>
						<?php else: ?>
							<?php if (!empty($tasksUnchecked)): ?>
								<?php foreach ($tasksUnchecked as $row): ?>
									<div class="checkbox">
									 	<label>
									    	<input type="checkbox" name="proj_tasks[]" value="<?= $row['todo_id']; ?>"><?= $row['todo_task']; ?>
									  	</label>
									</div>	
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if(!empty($tasksChecked)): ?>
								<?php foreach ($tasksChecked as $row): ?>
									<div class="checkbox">
									 	<label>
									    	<input type="checkbox" checked disabled><?= $row['todo_task']; ?>
									  	</label>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						<button type="submit" name="btn-CheckTasks" class="btn btn-md btn-info">Update tasks</button>
					<?php endif; ?>
					</form>
				</div> -->

	</div>
<?php include '../partials/footer.php'; ?>