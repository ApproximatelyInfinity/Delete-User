<?php 
	ob_start();
	include '/includes/authentication.php';
	include '/server/profile_delete_server.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include '/includes/header.php'; ?>
	</head>
	<body>
		<?php 
			if (!isset($_SESSION['username'])) {
				include "/includes/navbar_login.php";
			}else{
				include "/includes/navbar_logout.php";
			}
		?>
		<div class="content">
			<div class="main">
				<div class="container" style="background-color: white; padding-bottom: 16px;">
					<div class="padding" style="padding-top:70px"></div>
					<h1><i>Adiós Ciao Bon-Voyage Goodbye</i></h1>
					<p>To delete your account type <strong>DELETE</strong> in the box below, and provide your email/username, your current password, and reason for leaving.</p>
					<?php include '/includes/success.php'; ?>
					<?php include'/includes/errors.php'; ?>
					<form method="post" action="goodbye.php">
						<div class="form-group"><label>Delete</label><input class="form-control" type="text" name="delete"></div>
						<div class="form-group"><label>Username/Email</label><input class="form-control modal-username" type="text" name="username"></div>
						<div class="form-group"><label>Password</label><input class="form-control modal-password" type="password" name="password"></div>
						<div class="form-group"><label>Reason For Leaving</label><textarea class="form-control" type="text" rows="4" cols="50" name="reason"></textarea></div>
						<div class="form-group"><button type="submit" class="btn btn-purple" name="delete_user">Delete</button></div>
					</form>
				</div>
			</div>
		</div>
		<div class="padding" style="padding-top:70px"></div>
		<?php 
			include '/includes/footer.php';
			ob_end_flush();
		?>
	</body>
</html>