<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('http://localhost:8888/projectCenter/index.php');
	}

	$proj_name = $proj_desc = $proj_date_start = $proj_date_end = $proj_users_id = $proj_todos = "" ;

	if(isset($_POST['btn-newProject'])) {
		$proj_name 			= $_POST['txt_proj_name'];
		$proj_desc 			= $_POST['txt_proj_desc'];
		$proj_date_start 	= $_POST['txt_proj_date_start'];
		$proj_date_end 		= $_POST['txt_proj_date_end'];
		$chk				= "";  

		if (!empty($_POST['txt_user_id'])) {
			$proj_users_id = $_POST['txt_user_id'];
		} else {
			$proj_users_id = isset($_POST['txt_user_id']);
		}

		if (!empty($_POST['txt_proj_todo'])) {
			$proj_tasks = $_POST['txt_proj_todo'];
		} else {
			$proj_tasks = isset($_POST['txt_proj_todo']);
		}

		if (empty($proj_name)) {
			$error[] = "Please provide a project name for this project!"; 
		} elseif(strlen($proj_name) < 7) {
			$error[] = "Project name has to be at least 7 character long"; 
		} elseif (empty($proj_desc)) {
			$error[] = "Please provide a description for this project!"; 
		} elseif(strlen($proj_desc) < 15) {
			$error[] = "Project name has to be at least 15 character long"; 
		} elseif (empty($proj_date_start)) {
			$error[] = "Please provide an start date for this project!"; 
		} elseif (empty($proj_date_end)) {
			$error[] = "Please provide an end date for this project!"; 
		} elseif ($proj_date_start > $proj_date_end) {
			$error[] = "The end date must be set AFTER the start date";
		} else {
			try {
				if($projects->newProject($proj_name, $proj_desc, $proj_date_start, $proj_date_end, $proj_users_id, $chk, $proj_tasks)) {
					$user->redirect('create-project.php?ProjCreated');
				}
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}
	include '../partials/header.php';
	include '../partials/nav.php';
?>
<form method="POST">
	<div class="container-fluid create-project">
		<?php if(isset($error)) { foreach($error as $error) { ?>
			<div class="row">
				<div class="alert alert-danger col-xs-12">
					<a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
					<i class="glyphicon glyphicon-warning-sign"></i><?php echo $error; ?>
				</div>
			</div>
		<?php }} else if(isset($_GET['ProjCreated'])) { ?>
			<div class="row">
				<div class="alert alert-info">
					<a href="#" class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
		 			<i class="fa fa-bell"></i> Successfully registered. <a href='home.php'>Back to home</a>
				</div>
			</div>				
		<?php } ?>
		<div class="panel mb0 row">
			<div class="panel-heading col-xs-12">
				<h5 class="panel-title text-left">
					New Project
				</h5>
			</div>
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Project Name <small class="tiny">Max 60 characters</small>
				</p>
			</div>
		</div>
		<div class="panel-content row">
			<div class="input-group col-xs-12">
			  <input type="text" class="form-control" name="txt_proj_name" placeholder="" value="<?php if(isset($error)){echo $proj_name;}?>" />
			</div>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Project Description <small class="tiny">Max 250 characters</small>
				</p>
			</div>
		</div>
		<div class="panel-content row">
			<div class="input-group col-xs-12">
				<textarea name="txt_proj_desc" class="form-control"><?php if(isset($error)){echo $proj_desc;}?></textarea>
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
				<input type="date" name="txt_proj_date_start" value="<?= $singleProjectsRow['proj_date_start']; ?>" class="form-control"/>
			</div>
			<div class="col-xs-6 text-center date">
				<input type="date" name="txt_proj_date_end" value="<?= $singleProjectsRow['proj_date_end']; ?>" class="form-control" />
			</div>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Select your team
				</p>
			</div>
		</div>
		<div class="panel-content project-team row">
			<?php foreach ($departments as $row): ?>
				<div class="col-xs-12 pt10 pb10 border-bottom">
					<div class="row">
						<div class="col-xs-2">
							<input type="checkbox" name="txt_user_id[]" value="<?= $row['user_id']; ?>">
						</div>
						<div class="col-xs-3 profile">
							<img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" />
						</div>
						<div class="col-xs-7">
							<p><?= $row['user_firstname']. " " .$row['user_lastname']; ?></p>
							<span><?= $row['department_name']; ?></span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="panel mb0 row">
			<div class="panel-heading subheading col-xs-12">
				<p class="panel-title subtitle text-left">
					Add your tasks <button class="btn btn-xs btn-success btn-circle add-task-btn pull-right"><i class="fa fa-plus"></i> </button>
				</p>
			</div>
		</div>
		<div class="panel-content tasklist row">
			<div class="col-xs-12">
				<div class="row step-todo">
				</div>
			</div>		
		</div>
		<div class="row">
			<button type="submit" class="btn btn-lg btn-block btn-primary" name="btn-newProject">
				 <i class="fa fa-plus"></i>Create Project
			</button>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<a href="../home.php" class="btn btn-block btn-outline btn-to-home mt15"><i class="fa fa-home pull-left"></i> Back to home</a>	
			</div>
		</div>			
	</div>
</form>

<?php include '../partials/footer.php'; ?>
