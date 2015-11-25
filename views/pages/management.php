<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('http://localhost:8888/projectCenter/index.php');
	}

    if (isset($_POST['editUser'])) {
	    $_SESSION['user_id_edit'] = $_POST['user_id_edit'];
        $user->redirect('edit-user.php');

    } else if(isset($_POST["deleteUser"])){
    	$user_id_edit = $_POST['user_id_edit'];

		if($user->delete_user($user_id_edit)) {
			$user->redirect('management.php?userDeleted');
		}
	} else if (isset($_POST["showUserDept"])) {
		$department_id = $_POST['department_id'];
			if($user->userDepartments($department_id)) {
				$user->redirect('management.php?sortByDept='.$department_id.'');
			}
	}

	include '../partials/header.php';
	include '../partials/nav.php';

?>
<div class="container-fluid">
	<?php if(isset($_GET['userDeleted'])): ?>
		<div class="row">
			<div class="col-xs-12 alert alert-success alert-fadeout">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				User was deleted successfully!
			</div>
		</div>
	<?php endif; ?>
	<div class="accordion-icons management">
    <div class="panel mb0 row">
      <div class="panel-heading col-xs-12">
        <h5 class="panel-title text-left">
          The Team
        </h5>
      </div>
  	</div>
		<?php foreach ($allUsers as $row): ?>
			<div class="panel row mb5">
				<div class="panel-heading subheading-alt collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#user-<?= $row['user_id']; ?>">
					<div class="row">
						<!-- <a class="collapsed"> -->
							<div class="picture text-left col-xs-3">
	       				<img src="<?= $assetsImg.'/avatars/'.$row['avatar_url']; ?>">
	       			</div>
	       			<div class="col-xs-7">
	       				<p class="ellipsis"><?= $row['user_firstname'] . ' ' . $row['user_lastname']; ?></p>
	       				<span><?= $row['department_name']; ?></span>
	       			</div>
	       			<i class="indicator fa fa-chevron-down text-right col-xs-2"></i>
		        <!-- </a> -->
	        </div>
				</div>
				<div id="user-<?= $row['user_id']; ?>" class="panel-collapse collapse" role="tabpanel">
					<div class="project-lists">
						<a href="tel:5555555555" class="btn btn-lg btn-success col-xs-6 border-right">Tel</a>
						<a href="mailto:<?= $row['user_email']; ?>" class="btn btn-lg btn-info col-xs-6">Mail</a>
					</div>
					<?php if($usertype == 1) : ?>
							<form method="POST">
								<button type="submit" class="btn btn-sm btn-warning col-xs-6 border-right mt5" name="editUser">Edit</button>
								<button type="submit" class="btn btn-sm btn-danger col-xs-6 mt5" name="deleteUser" onclick="return confirm(\'Really delete?\');">Delete</button>
								<input type="hidden" name="user_id_edit" value="<?= $row['user_id'] ?>">
							</form>
					<?php endif; ?>
				</div>
	  	</div>
		<?php endforeach; ?>
	</div>
</div>


<?php include '../partials/footer.php'; ?>





<?php /*
			<div class="col-md-10">
				<table class="table">
					<thead>
						<th>Avatar</th>
						<th>Name</th>
						<th>E-mail</th>
						<th>Department</th>
						<th>Actions</th>
						
					</thead>
					<tbody>
					<?php foreach ($allUsers as $row): ?>
						<tr>
							<td><img src="<?= $assetsImg . "/avatars/" . $row['avatar_url']; ?>" width="100px" /></td>
							<td><?= $row['user_firstname'] . " " . $row['user_lastname']; ?></td>
							<td><a href="mailto:<?= $row['user_email'] ?>"><?= $row['user_email'] ?></a></td>
							<td>

							</td>
							<?php if($usertype == 1) : ?>
								<td>
									<form method="POST">
										<button type="submit" class="btn btn-sm btn-info" name="editUser">Edit</button>
										<button type="submit" class="btn btn-sm btn-warning" name="deleteUser" onclick="return confirm(\'Really delete?\');">Delete</button>
										<input type="hidden" name="user_id_edit" value="<?= $row['user_id'] ?>">
									</form>
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class="col-3">
			<?php if(isset($_GET['sortByDept'])): 
				$dept_id = $_GET['sortByDept'];
				$sortDept = $user->userDepartments($dept_id);	
				
				foreach ($sortDept as $row): ?>
					<p><?= $row['user_firstname'];?></p>
					<p><?= $row['department_name'];?></p>
				<?php endforeach; ?>

			<?php endif; ?>
			</div>
		</div>
</div>


	//THIS IS FOR SHOW ALL IN SELECTED DEPARTMENTS
	<form method="POST">
		<input type="hidden" name="department_id" value="<?= $row['department_id']; ?>">
		<button name="showUserDept" class="openModal"><?= $row['department_name'] ?></button>
	</form>
*/
?>