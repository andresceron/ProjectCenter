<?php
	include_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}

    // Fetch selected PROJECT and redirect to..
    if (isset($_POST['projectDetail'])) {
	    $_SESSION['proj_id'] = $_POST['proj_id'];
        header('location: project-detail.php');
    }

	include '../partials/header.php';
	include '../partials/nav.php';
?>
	<div class="container content">
		<div class="row">
			<div class="col-md-12">
			<?php if(isset($_GET['userLoggedIn'])): ?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Welcome: <?= $userInfo['user_firstname'] . " " . $userInfo['user_lastname']?> If you need any support, write to support@support.com	
				</div>
				
			<?php endif; ?>
			</div>
			<div class="col-md-8 accordion-icons">
				<div class="panel panel-default">
					<div class="panel-heading" role="button" data-toggle="collapse" data-parent="#accordion" href="#activeProjects">
						<h4 class="panel-title">
					        <a class="collapsed">
			         			<i class="indicator glyphicon glyphicon-chevron-up  pull-left"></i>
			         				Active projects
			         			<i class="indicator glyphicon glyphicon-chevron-up  pull-right"></i>
					        </a>
				    	</h4>
					</div>

					<div id="activeProjects" class="panel-collapse collapse in" role="tabpanel">
						<div class="panel-body">
							<div class="list-group">
								<div class="project-lists">
									<?php $projRows = $user->upcomingProjects($user_id); ?>
									<?php if ($projRows === false): ?>
										<p>No active projects yet</p></br>
										<a href="create-project.php" class="btn btn-primary btn-md">Create new project</a> 
									<?php else: ?>
										<?php foreach ($projRows as $row): ?>
											<form method="post" action="home.php">
											<button name="projectDetail"><?= $row['proj_name']; ?>
												<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
											</button>
											<span><?= $row['proj_date_start'] ?></span>
											<hr>
											</form>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
					  	</div>
				  	</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" role="button" data-toggle="collapse" data-parent="#accordion" href="#upcomingProjects">
						<h4 class="panel-title">
					        <a class="collapsed">
			         			<i class="indicator glyphicon glyphicon-chevron-down  pull-left"></i>
			         				Upcoming projects
			         			<i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
					        </a>
				    	</h4>
					</div>
					<div id="upcomingProjects" class="panel-collapse collapse" role="tabpanel">
						<div class="panel-body">
							<div class="list-group">
								<div class="project-lists">
									<?php $projRows = $user->upcomingProjects($user_id); ?>
									<?php if ($projRows === false): ?>
										<span>No upcoming projects yet</span>
									<?php else: ?>
										<?php foreach ($projRows as $row): ?>
											<form method="post" action="home.php">
											<button name="projectDetail"><?= $row['proj_name']; ?>
												<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
											</button>
											<span><?= $row['proj_date_start'] ?></span>
											<hr>
											</form>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
					  	</div>
				  	</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="button" data-toggle="collapse" href="#previousProjects">
						<h4 class="panel-title">
					        <a class="collapsed">
			         			<i class="indicator glyphicon glyphicon-chevron-down  pull-left"></i>
			         				Previous projects
			         			<i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
					        </a>
				    	</h4>
					</div>
					<div id="previousProjects" class="panel-collapse collapse" role="tabpanel">
						<div class="panel-body">
							<div class="list-group">
								<div class="project-lists">
									<?php $projRows = $user->previousProjects($user_id); ?>	
									<?php foreach ($projRows as $row): ?>	
										<form method="post" action="home.php">
											<button name="projectDetail"><?= $row['proj_name']; ?>
												<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
											</button>
											<span><?= $row['proj_date_start'] . " - " . $row['proj_date_end'] ?></span>
											<hr>
										</form>	
									<?php endforeach;?>
								</div>
							</div>
					  	</div>
				  	</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading"  role="button" data-toggle="collapse" data-parent="#accordion" href="#allProjects">
						<h4 class="panel-title">
					        <a class="collapsed">
								<i class="indicator glyphicon glyphicon-chevron-down  pull-left"></i>
			         				All projects
			         			<i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i>
					        </a>
				    	</h4>
					</div>
					<div id="allProjects" class="panel-collapse collapse" role="tabpanel">
						<div class="panel-body">
							<div class="list-group">
								<div class="project-lists">
									<?php 
										if($usertype == "1") { // Admin
											foreach ($allProjects as $row): ?>	
												<form method="post" action="home.php">
												<button name="projectDetail"><?= $row['proj_name']; ?>
													<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
												</button>
												<hr>
												</form>
											<?php endforeach;
										} elseif ($usertype == "2") { // User
											echo "hej";
										}
									?>
								</div>
							</div>
					  	</div>
				  	</div>
				</div>
			</div>
			<div class="col-md-4">
				<?php include '../partials/sidebar.php'; ?>
			</div>
		</div>
	</div>
<?php include '../partials/footer.php'; ?>