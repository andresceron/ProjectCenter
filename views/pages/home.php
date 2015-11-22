<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('http://localhost:8888/projectCenter/index.php');
	}	

    // Fetch selected PROJECT and redirect to..
    if (isset($_POST['projectDetail'])) {
	    $proj_id = $_POST['proj_id'];
	    //$_SESSION['proj_id'] = $_POST['proj_id'];
        //$user->redirect('project-detail.php?');
        $user->redirect('project-detail.php?showProj='.$proj_id.'');
    }

	if (isset($_POST['editUser'])) {
		$_SESSION['user_id_edit'] = $_POST['user_id_edit'];
		$user->redirect('edit-user.php');
	}

	include '../partials/header.php';
	include '../partials/nav.php';
?>
<main class="container-fluid">
		<?php if(isset($_GET['userLoggedIn'])): ?>
			<div class="row">
				<div class="alert alert-success alert-fadeout mb0 col-xs-12">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					Welcome: <?= $userInfo['user_firstname'] . " " . $userInfo['user_lastname']?> If you need any support, write to support@support.com	
				</div>
			</div>
		<?php endif; ?>
		<div class="accordion-icons">
			<div class="panel mb0 row">
				<div class="panel-heading" role="button" data-toggle="collapse" data-parent="#accordion" href="#activeProjects">
					<div class="row">
						<a class="collapsed">
							<h5 class="panel-title text-left col-xs-10">
		         				Active projects <span>(<?= count($activeProjects); ?>)</span>
		         			</h5>
		         			<i class="indicator fa fa-chevron-up text-right col-xs-2"></i>
				        </a>
			        </div>
				</div>
				<div id="activeProjects" class="panel-collapse collapse in" role="tabpanel">
					<div class="project-lists">
						<?php if ($activeProjects === false): ?>
							<p>No active projects yet</p>
							<a href="create-project.php" class="btn btn-primary btn-md">Create new project</a> 
						<?php else: ?>
							<?php foreach ($activeProjects as $row): ?>
								<form method="post" action="home.php">
									<button type="submit" name="projectDetail" class="btn btn-full">
										<div class="pull-left title">
											<p class="mb5 text-left ellipsis"><?= $row['proj_name']; ?></p>
											<span class="dblock text-left ellipsis"><?= $row['proj_desc']?></span>
										</div>
										<div class="pull-right">
											<i class="fa fa-chevron-circle-right pt10"></i>
										</div>
										<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
									</button>
								</form>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
			  	</div>
			</div>
			<div class="panel mb0 row">
				<div class="panel-heading" role="button" data-toggle="collapse" data-parent="#accordion" href="#upcomingProjects">
			        <div class="row">
				        <a class="collapsed">
		         			<h5 class="panel-title text-left col-xs-10">
		         				Upcoming projects <span>(<?= count($upcomingProjects); ?>)</span>
					    	</h5>
		         			<i class="indicator fa fa-chevron-down text-right col-xs-2"></i>
				        </a>
			        </div>
				</div>
				<div id="upcomingProjects" class="panel-collapse collapse" role="tabpanel">
					<div class="project-lists">
						<?php if ($upcomingProjects === false): ?>
							<p>No upcoming projects yet</p>
						<?php else: ?>
							<?php foreach ($upcomingProjects as $row): ?>
								<form method="post" action="home.php">
									<button type="submit" name="projectDetail" class="btn btn-full">
										<div class="pull-left title">
											<p class="mb5 text-left ellipsis"><?= $row['proj_name']; ?></p>
											<span class="dblock text-left ellipsis"><?= $row['proj_desc'] ?></span>
										</div>
										<div class="pull-right">
											<i class="fa fa-chevron-circle-right pt10"></i>
										</div>
										<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
									</button>
								</form>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
			  	</div>
			</div>
			<div class="panel mb0 row">
				<div class="panel-heading" role="button" data-toggle="collapse" href="#previousProjects">
					<div class="row">
				        <a class="collapsed">
		         			<h5 class="panel-title text-left col-xs-10">
		         				Previous projects <span>(<?= count($previousProjects); ?>)</span>
					    	</h5>
		         			<i class="indicator fa fa-chevron-down text-right col-xs-2"></i>
				        </a>
			    	</div>
				</div>
				<div id="previousProjects" class="panel-collapse collapse" role="tabpanel">
					<div class="project-lists">
						<?php if ($previousProjects === false): ?>
							<p>No previous projects yet</p>
						<?php else: ?>
							<?php foreach ($previousProjects as $row): ?>	
								<form method="post" action="home.php">
									<button type="submit" name="projectDetail" class="btn btn-full">
										<div class="pull-left title">
											<p class="mb5 text-left ellipsis"><?= $row['proj_name']; ?></p>
											<span class="dblock text-left ellipsis"><?= $row['proj_desc'] ?></span>
										</div>
										<div class="pull-right">
											<i class="fa fa-chevron-circle-right pt10"></i>
										</div>
										<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
									</button>
								</form>
							<?php endforeach;?>
						<?php endif;?>
					</div>
			  	</div>
			</div>
			<div class="panel mb0 row">
				<div class="panel-heading"  role="button" data-toggle="collapse" data-parent="#accordion" href="#allProjects">
					<div class="row">
				        <a class="collapsed">
							<h5 class="panel-title col-xs-10">
	         					<?= (($usertype == 1 ? "All projects " . "(" .count($allProjects) . ")" : "My projects " . "(" . count($userProjects) . ")")); ?>
	         				</h5>
		         			<i class="indicator fa fa-chevron-down text-right col-xs-2"></i>
				        </a>
					</div>
				</div>
				<div id="allProjects" class="panel-collapse collapse" role="tabpanel">
					<div class="project-lists">
						<?php if($usertype == "1") : // Admin
							foreach ($allProjects as $row): ?>	
								<form method="post" action="home.php">
									<button type="submit" name="projectDetail" class="btn btn-full">
										<div class="pull-left title">
											<p class="mb5 text-left ellipsis"><?= $row['proj_name']; ?></p>
											<span class="dblock text-left ellipsis"><?= $row['proj_desc'] ?></span>
										</div>
										<div class="pull-right">
											<i class="fa fa-chevron-circle-right pt10"></i>
										</div>
										<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
									</button>
								</form>
						<?php endforeach; elseif ($usertype == "2") : // User
							foreach ($userProjects as $row): ?>	
								<form method="post" action="home.php">
									<button name="projectDetail" class="btn btn-full">
										<p class="mb0"><?= $row['proj_name']; ?></p>	
										<span><?= $row['proj_date_start'] . " - " . $row['proj_date_end'] ?></span>
										<input type="hidden" name="proj_id" value="<?= $row['proj_id'] ?>">
									</button>
								</form>
						<?php endforeach; endif; ?>
				  	</div>
			  	</div>
			</div>
		</div>
	</div>
</main>

<?php include '../partials/footer.php'; ?>

