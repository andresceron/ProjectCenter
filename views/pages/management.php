<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('../../index.php');
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
<div class="container content">
	<div class="row">
		<div class="col-md-12">
			<?php if(isset($_GET['userDeleted'])): ?>
				<div class="alert alert-success alert-fadeout">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					User was deleted successfully!
				</div>
			<?php endif; ?>
		</div>
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
							<form method="POST">
								<input type="hidden" name="department_id" value="<?= $row['department_id']; ?>">
								<button name="showUserDept" class="openModal"><?= $row['department_name'] ?></button>
							</form>
						</td>
						<?php if($usertype == 1) : ?>
							<td>
								<form method="POST">
									<button type="submit" class="btn btn-sm btn-info" name="editUser">Edit</button>
									<button type="submit" class="btn btn-sm btn-warning" name="deleteUser" onclick="return confirm(\'Really delete?\');">Delete</button>
									<input type="hidden" name="user_id_edit" value="<?= $row['user_id'] ?>">
								</form>
							</td>
						<?php else: ?>
							<td>
								<a href="tel:5555555555">Call</a>
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

<?php include '../partials/footer.php'; ?>