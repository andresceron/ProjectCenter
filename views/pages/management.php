<?php
	require_once '../../dbconfig.php';
	require_once '../../user_id.php';

	if(!$user->is_loggedin()) {
		$user->redirect('../../index.php');
	}

    if (isset($_POST['editUser'])) {
	    $_SESSION['user_id_edit'] = $_POST['user_id_edit'];
        $user->redirect('edit-user.php');
    }

	include '../partials/header.php';
	include '../partials/nav.php';

if(isset($_POST['edit-user']))

?>
<div class="container content">
	<div class="row">
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
						<td><a href="#"><?= $row['department_name'] ?></a></td>
						<?php if($usertype == 1) : ?>
							<td>
								<form method="POST">
									<button type="submit" class="btn btn-sm btn-info" name="editUser">Edit</button>
									<input type="button" class="btn btn-sm btn-warning" name="deleteUser" value="Delete">
									<input type="hidden" name="user_id_edit" value="<?= $row['user_id'] ?>">
								</form>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>