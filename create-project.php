<?php
	require_once 'dbconfig.php';
	require_once 'user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}

	if(isset($_POST['btn-newProject'])) {
		$proj_name 			= $_POST['txt_proj_name'];
		$proj_desc 			= $_POST['txt_proj_desc'];
		$proj_date_start 	= $_POST['txt_proj_date_start'];
		$proj_date_end 		= $_POST['txt_proj_date_end'];
 
		if (empty($proj_name)) {
			$error[] = "provide Proj Name !"; 
		} elseif (empty($proj_desc)) {
			$error[] = "provide Proj Desc !"; 
		} elseif (empty($proj_date_start)) {
			$error[] = "provide start date !"; 
		} elseif (empty($proj_date_end)) {
			$error[] = "provide end date!"; 
		} else {
			try {
				if($user->newProject($proj_name, $proj_desc, $proj_date_start, $proj_date_end)) {
					$user->redirect('create-project.php?ProjCreated');
				}
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}
	include 'includes/header.php';
?>
	<div class="container">
	 	<div class="form-container">
			<form method="post">
				<p>Logged in as: <?= ($userRow['user_firstname']); ?></p>
				<h2>Create a new project</h2><hr />
				
				</br>
				<?php
				if(isset($error)) { foreach($error as $error) { ?>
					<div class="alert alert-danger">
						<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
					</div>
				<?php }} else if(isset($_GET['projectCreated'])) { ?>
					<div class="alert alert-info">
			 			<i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='/home.php'>Back to home</a>
					</div>
				<?php } ?>
				<div class="form-group">
					<input type="text" class="form-control" name="txt_proj_name" placeholder="Project Name" value="<?php if(isset($error)){echo $proj_name;}?>" />
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="txt_proj_desc" placeholder="Project Description" value="<?php if(isset($error)){echo $proj_desc;}?>" />
				</div>
				<div class="form-group">
					<input type="date" class="form-control" name="txt_proj_date_start" placeholder="Project Start date" value="<?php if(isset($error)){echo $proj_date_start;}?>" />
				</div>
				<div class="form-group">
					<input type="date" class="form-control" name="txt_proj_date_end" placeholder="Project End date" value="<?php if(isset($error)){echo $proj_date_end;}?>" />
				</div>
				<div class="clearfix"></div><hr />
				<div class="form-group">
					<button type="submit" class="btn btn-block btn-primary" name="btn-newProject">
						 <i class="glyphicon glyphicon-open-file"></i>&nbsp;CREATE PROJECT
					</button>
				</div>
				<br />
				<label>have an account ! <a href="index.php">Sign In</a></label>
			</form>
		</div>
	</div>
<?php include 'includes/footer.php';
