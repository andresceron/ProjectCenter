<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';
	//$proj_id = $_SESSION['proj_id'];

	if(!$user->is_loggedin()) {
		$user->redirect('/projectCenter/index.php');
	} elseif ($usertype != 1) {
		$user->redirect('/projectCenter/home.php');
	}

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
					$user->redirect('edit-project.php?projId='.$proj_id.'&ProjectUpdated');
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
	<div class="container-fluid edit-proj">
			<?php if(isset($error)) { foreach($error as $error) { ?>
			<div class="row">
				<div class="alert alert-danger col-xs-12">
					<i class="fa fa-explamation"></i> &nbsp; <?php echo $error; ?>
				</div>
			</div>
			<?php }} ?>
		<!-- <form method="POST"> -->
			<?php if(isset($_GET['ProjectUpdated'])) : ?>
				<div class="row">
					<div class="alert alert-info col-xs-12">
						<a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
			 			Project Updated. <a href="project-detail.php?showProj=<?= $proj_id ?>" >Back to project</a>
					</div>
				</div>	
			<?php elseif(isset($_GET['newTaskAdded'])): ?>
			<div class="row">
				<div class="alert alert-info col-xs-12">
					<a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
		 			<i class="glyphicon glyphicon-log-in"></i> New task added to project!
				</div>
			</div>	
			<?php elseif(isset($_GET['teamMemberDeleted'])): ?>
			<div class="row">
				<div class="alert alert-info col-xs-12">
					<a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
		 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; <?= $getData['user_firstname']; ?> Removed from Project
				</div>
			</div>
			<?php elseif(isset($_GET['deletedTask'])): ?>
			<div class="row">
				<div class="alert alert-info co-xs-12">
					<a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
		 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; Task was deleted from project!
				</div>
			</div>
			<?php endif; ?>
		<div class="panel mb0 row">
			<div class="panel-heading col-xs-12">
				<h5 class="panel-title text-left">
					Edit Project
				</h5>
			</div>
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Project Name
				</p>
			</div>
		</div>
		<div class="panel-content row">
			<div class="input-group col-xs-12">
			  <input type="text" name="proj_name" value="<?= $singleProjectsRow['proj_name']; ?>" class="form-control" />
			</div>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Project Description
				</p>
			</div>
		</div>
		<div class="panel-content row">
			<div class="input-group col-xs-12">
				<textarea name="proj_desc" class="form-control"><?= $singleProjectsRow['proj_desc']; ?></textarea>
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
			<div class="col-xs-6 text-center border-right date">
				<input type="date" name="proj_date_start" value="<?= $singleProjectsRow['proj_date_start']; ?>" class="form-control"/>
			</div>
			<div class="col-xs-6 text-center date">
				<input type="date" name="proj_date_end" value="<?= $singleProjectsRow['proj_date_end']; ?>" class="form-control" />
			</div>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Project Actions
				</p>
			</div>
		</div>
		<div class="panel-content status border-bottom row">
			<form method="POST">
				<div class="col-xs-6">
					<button type="submit" class="btn btn-full-multi btn-links btn-info" name="btn-updateProj" value="Update Project">Update Project</button>
				</div>
				<div class="col-xs-6">
					<button type="submit" class="btn btn-full-multi btn-links btn-danger" name="btn-deleteProj" value="Delete Project">Delete Project</button>
				</div>
			</form>
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
						<div class="col-xs-7">
							<p class="mt10 ellipsis"><?= $row['user_firstname'] . " " . $row['user_lastname']; ?></p class="mt10">
						</div>
						<div class="col-xs-2">
							<input type="hidden" name="del_team_member" value="<?= $row['user_id']; ?>"/>
							<button type="submit" name="btn-delMember" class="btn btn-xs btn-danger btn-circle mt10"><i class="fa fa-minus"></i></button>
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
					<p class="mt10">No tasks assigned</p>
				</div>
			<?php else: ?>
				<div class="col-xs-12">
					<?php foreach ($singleProjectsTasks as $row): ?>
						<div class="row pt10 pb10 border-bottom">
							<div class="col-xs-10">
								<p><?= $row['todo_task']; ?></p>
							</div>
							<div class="col-xs-2">
								<input type="hidden" name="del_task" value="<?= $row['todo_id']; ?>">
								<button type="submit" name="btn-delTask" class="btn btn-xs btn-danger btn-circle"><i class="fa fa-minus"></i></button>
							</div>	
						</div>
						<!-- <form method="POST"> -->
						<!-- </form> -->
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="col-xs-12">
				<div class="row">
					<div class="col-xs-10 p0">
						<input type="text" name="add_new_task" class="form-control" placeholder="Add new task to this project" />	
					</div>
					<div class="col-xs-2 mt15">
						<button type="submit" name="btn-addTask" class="btn btn-xs btn-success btn-circle"><i class="fa fa-plus"></i> </button>
					</div>
				</div>
			</div>		
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<a href="project-detail.php?showProj=<?= $proj_id ?>" class="btn btn-block btn-outline btn-to-home btn-links mt15"><i class="fa fa-chevron-left pull-left"></i> Back to project info</a>	
			</div>
			<div class="col-xs-12">
				<a href="../home.php" class="btn btn-block btn-outline btn-to-home btn-links mt15"><i class="fa fa-home pull-left"></i> Back to home</a>	
			</div>
		</div>			
	</div>
</form>
<?php include '../partials/footer.php'; ?>