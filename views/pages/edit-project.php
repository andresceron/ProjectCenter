<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';
	//$proj_id = $_SESSION['proj_id'];
	$proj_id = $_GET['projId'];
	$singleProjectsTasks = $projects->singleProjectTasks($proj_id);
	
	if(!empty($_GET['teamMemberDeleted'])) {
		$get_id = $_GET['teamMemberDeleted'];
	} elseif (!empty($_GET['teamMemberAdded'])) {
		$get_id = $_GET['teamMemberAdded'];
	} else {
		$get_id = "";
	}

	$singleProjectsRow = $projects->singleProject($proj_id);
	$allUsersProj      = $projects->allUsersProj($proj_id);
	$getData 		   = $user->simpleData($get_id);

	if(!$user->is_loggedin()) {
		$user->redirect('http://localhost:8888/projectCenter/index.php');
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
	} elseif (isset($_POST['btn-delMember'])) {
		$team_member = $_POST['del_team_member'];

		if($projects->deleteMember($proj_id, $team_member)) {
			$user->redirect('edit-project.php?projId='.$proj_id.'&teamMemberDeleted='.$team_member.'');
		}
	} elseif (isset($_POST['btn-addTask'])) {
		$new_task = $_POST['add_new_task'];
		// print_r($team_member);
		// die;
		if($projects->addTasks($new_task, $proj_id)) {
			$user->redirect('edit-project.php?projId='.$proj_id.'&newTaskAdded');
		}
	} elseif (isset($_POST['btn-delTask'])) {
		$del_task = $_POST['del_task'];

		if($projects->delTasks($del_task)) {
			$user->redirect('edit-project.php?projId='.$proj_id.'&deletedTask='.$del_task.'');
		}
	}


	include '../partials/header.php';
	include '../partials/nav.php';
?>
<form method="POST">
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
				<!-- <form method="POST"> -->
					<?php if(isset($_GET['StatusUpdated'])) : ?>
						<div class="alert alert-info">
				 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; Project Status changed to...
				 				<?= ($singleProjectsRow['proj_state'] == 1 ? "Active" : ($singleProjectsRow['proj_state'] == 2 ? 'Done' : 'Upcoming') ); ?>
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
				<!-- </form> -->
			</div>
			<!-- <form method="POST"> -->
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<?php if(isset($_GET['newTaskAdded'])): ?>
							<div class="alert alert-info">
					 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; New task added to project!
							</div>
						<?php elseif(isset($_GET['teamMemberDeleted'])): ?>
							<div class="alert alert-info">
					 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; <?= $getData['user_firstname']; ?> Removed from Project
							</div>
						<?php elseif(isset($_GET['deletedTask'])): ?>
							<div class="alert alert-info">
					 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; Task was deleted from project!
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="project-team">
					<h4>The Team</h4>
					<?php if ($allUsersProj === false): ?>
						<p>No users</p>
					<?php else: foreach ($allUsersProj as $row): ?>
						
							<div class="row">
								<div class="col-md-10 text-left">
									<img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" width="50px" />
									<span><?= $row['user_firstname'] . " " . $row['user_lastname']; ?></span>
								</div>
								<div class="col-md-2">
									<input type="hidden" name="del_team_member" value="<?= $row['user_id']; ?>"/>
									<button type="submit" name="btn-delMember" class="btn btn-xs btn-danger">Delete</button>
								</div>
							</div><br/>
					<?php endforeach; endif; ?>
				</div>
				<div class="project-tasks">
					<h4>The Tasks</h4>
					<div class="row">
					<?php if ($singleProjectsTasks === false): ?>
						<p>No tasks</p>
					<?php else: foreach ($singleProjectsTasks as $row): ?>
						<!-- <form method="POST"> -->
							<div class="col-md-10">
								<p><?= $row['todo_task']; ?></p>
							</div>
							<div class="col-md-2">
								<input type="hidden" name="del_task" value="<?= $row['todo_id']; ?>">
								<button type="submit" name="btn-delTask" class="btn btn-xs btn-danger">Delete</button>
							</div>		
						<!-- </form> -->
					<?php endforeach; endif; ?>
					</div>
					<!-- <form method="POST"> -->
						<div class="row">
							<div class="col-md-10 text-left">
								<input type="text" name="add_new_task" class="form-control" placeholder="Add new task to this project" />	
							</div>
							<div class="col-md-2">
								<button type="submit" name="btn-addTask" class="btn btn-xs btn-success">Add</button>
							</div>
						</div>	
					<!-- </form> -->
				</div>
			</div>
			<!-- </form> -->
		</div>
	</div>
</form>
<?php include '../partials/footer.php'; ?>