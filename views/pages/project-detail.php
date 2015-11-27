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
		$user->redirect('/index.php');
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
			$projects->checkTasks($task_id);
			$user->redirect('project-detail.php?showProj='.$proj_id.'&TasksUpdated');
		} else {
			$user->redirect('project-detail.php?showProj='.$proj_id.'&NoTasksUpdated');
		}
	}

	include '../partials/header.php';
	include '../partials/nav.php';
?>
<div class="container-fluid">
	<?php if(isset($_GET['TasksUpdated'])): ?>
		<div class="row">
			<div class="alert alert-success alert-fadeout mb0 col-xs-12">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				Tasks updated successfully!
			</div>
		</div>
	<?php elseif(isset($_GET['NoTasksUpdated'])): ?>
		<div class="row">
			<div class="alert alert-danger alert-fadeout mb0 col-xs-12">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				No tasks selected!
			</div>
		</div>
	<?php elseif(isset($_GET['StatusUpdated'])): ?>
		<div class="row">
			<div class="alert alert-success alert-fadeout mb0 col-xs-12">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				Project Status updated!
			</div>
		</div>
	<?php endif; ?>
	<div class="panel mb0 row">
		<div class="panel-heading title-section col-xs-12">
			<div class="row">
				<h5 class="panel-title text-left col-xs-10 <?= ($usertype == 1 ? "mt5" : ""); ?>"> 
					Project Details
				</h5>
				<div class="col-xs-2 text-right">
					<?php if($usertype == 1): ?>
						<form method="POST" class="inline cool-x">
							<button type="submit" class="btn btn-transparent btn-edit" name="btn-editProj" value="Edit">
								<i class="fa fa-pencil"></i>
							</button>
						</form>
					<?php endif; ?>	
				</div>
			</div>
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
						<div class="col-xs-12 pt10 pb10 border-bottom">
							<div class="row">
							 	<div class="col-xs-2">
							 		<input type="checkbox" name="proj_tasks[]" value="<?= $row['todo_id']; ?>">
							 	</div>
							 	<div class="col-xs-10">
							 		<p><?= $row['todo_task']; ?></p> 
							 	</div>
						 	</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<?php if(!empty($tasksChecked)): ?>
					<?php foreach ($tasksChecked as $row): ?>
						<div class="col-xs-12 pt10 pb10 border-bottom">
						 	<div class="row">
							 	<div class="col-xs-2">
							    	<input type="checkbox" checked disabled>
							  	</div>
							  	<div class="col-xs-10">
							  		<p><?= $row['todo_task']; ?></p>
							  	</div>
						  	</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<button type="submit" name="btn-CheckTasks" class="btn btn-block btn-links btn-update">Update tasks</button>
			</form>
		<?php endif; ?>
	</div>
	<?php if($usertype == 1) : ?>
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
					<button type="submit" class="btn btn-full-multi btn-links btn-blue" name="btn-status" value="Active">Active</button>
				</div>
				<div class="col-xs-4">
					<button type="submit" class="btn btn-full-multi btn-links btn-green" name="btn-status" value="Done">Done</button>
				</div>
				<div class="col-xs-4">
					<button type="submit" class="btn btn-full-multi btn-links btn-yellow" name="btn-status" value="Upcoming">Upcoming</button>
				</div>
			</form>
		</div>
	<?php endif; ?>
</div>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<a href="home.php" class="btn btn-block btn-outline btn-to-home btn-links mt15"><i class="fa fa-chevron-left pull-left"></i> Back to home</a>	
		</div>
	</div>			
</div>
<?php include '../partials/footer.php'; ?>