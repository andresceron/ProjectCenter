<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}

	$proj_name = $proj_desc = $proj_date_start = $proj_date_end = $proj_users_id = "" ;

	if(isset($_POST['btn-newProject'])) {
		$proj_name 			= $_POST['txt_proj_name'];
		$proj_desc 			= $_POST['txt_proj_desc'];
		$proj_date_start 	= $_POST['txt_proj_date_start'];
		$proj_date_end 		= $_POST['txt_proj_date_end'];
		$chk				= "";  

		if(!empty($POST['txt_user_id'])) {
			$proj_users_id	= $_POST['txt_user_id'];	
		} else {
			$proj_users_id = "";
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
		} elseif ($proj_date_start < $proj_date_end) {
			$error[] = "The end date must be set AFTER the start date";
		} else {
			try {
				if($user->newProject($proj_name, $proj_desc, $proj_date_start, $proj_date_end, $proj_users_id, $chk)) {
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

	<div class="container create-project">
		<p>Logged in as: <?= ($userInfo['user_firstname']); ?></p>
		<h2>Create a new project</h2><hr />
		</br>
		<?php if(isset($error)) { foreach($error as $error) { ?>
			<div class="alert alert-danger">
				<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
			</div>
		<?php }} else if(isset($_GET['ProjCreated'])) { ?>
			<div class="alert alert-info">
	 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='home.php'>Back to home</a>
			</div>
		<?php } ?>
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="progress progress-striped active">
        				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    				</div>
					<div class="row tasks">
				        <!-- <div class="col-md-2">
				          	<input type="button" value="10">
				          	<input type="button" value="20">HEJ</button>
				        </div> -->
			      	</div>

					<form method="post">
						<div class="step-name">
							<label class="col-md-2">Project name: </label>
							<div class="col-md-10 form-group">
								<input type="text" class="form-control" name="txt_proj_name" placeholder="Project Name" value="<?php if(isset($error)){echo $proj_name;}?>" />
							</div>
							<label class="col-md-2">Description: </label>
							<div class="col-md-10 form-group">
								<input type="text" class="form-control" name="txt_proj_desc" placeholder="Project Description" value="<?php if(isset($error)){echo $proj_desc;}?>" />
							</div>	
						</div>
						<div class="step-date">
							<label class="col-md-2">Start date: </label>
							<div class="col-md-10 form-group">
								<input type="date" class="form-control" name="txt_proj_date_start" placeholder="Project Start date" value="<?php if(isset($error)){echo $proj_date_start;}?>"/>
							</div>						
							<label class="col-md-2">End date:</label>
							<div class="col-md-10 form-group">
								<input type="date" class="form-control" name="txt_proj_date_end" placeholder="Project End date" value="<?php if(isset($error)){echo $proj_date_end;}?>"/>
							</div>		
						</div>
						<div class="step-team">
							<h4>Select your Team:</h4>
							<?php foreach ($departments as $row): ?>
								<div class="checkbox">
								 	<label>
								    	<input type="checkbox" name="txt_user_id[]" value="<?= $row['user_id']; ?>"><?= $row['user_firstname'] . " | " . $row['department_name']; ?>
								  	</label>
								</div>	
							<?php endforeach ?>
						</div>
						<div class="step-create">
							<div class="form-group col-md-12">
								<button type="submit" class="btn btn-md btn-primary" name="btn-newProject">
									 <i class="glyphicon glyphicon-open-file"></i>&nbsp;CREATE PROJECT
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php /* 
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">Project Information</div>
					<div class="panel-body">
					<?php //TODO: Generate the previous projects
						if (false) : ?>	
						<div class="list-group">
							<div class="project-lists">
								<a href="#" class="unlisted-group">...</a>
							</div>
						</div>
					<?php else : ?>
		    			<p>...??...</p>
		    		<?php endif; ?>
			  	</div>
			</div>
			*/ ?>
			</div>
		</div>
	</div>
<?php include '../partials/footer.php'; ?>
