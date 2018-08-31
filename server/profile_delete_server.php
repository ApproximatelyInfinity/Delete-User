<?php 
	session_start();
	
	//Initalize the variables
	$errors = array();
	$success = array();
	
	//Connects to the database
	include '/includes/database_conn.php';
	
	//Gets user input from form
	if (isset($_POST['delete_user'])) {
		//Gets variables from the form input
		$delete = mysqli_real_escape_string($conn, $_POST['delete']);
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$reason = mysqli_real_escape_string($conn, $_POST['reason']);
		
		//Set variables from the current users session
		$user_id = $_SESSION['id'];
		$user_username = $_SESSION['username'];
		$user_email = $_SESSION['email'];
		
		//Form validation
		if (empty($delete)) {
			array_push($errors, "Please type DELETE in the delete box!");
		}
		if ($delete == "delete") {
			array_push($errors, "Please type DELETE in the delete box!");
		}
		if (empty($username)) {
			array_push($errors, "Username or email is required.");
		}
		if (empty($password)) {
			array_push($errors, "Password is required.");
		}
		if (empty($reason)) {
			array_push($errors, "Please give your reason for leaving so we can try to make Melodic Odyssey better.");
		}
		
		//If there no errors then continue with deletion process
		if(count($errors) == 0) {
			//Selects all the rows from the table called users
			$query = "SELECT * FROM users WHERE (username = '$username' OR email = '$username')";
			$result = mysqli_query($conn, $query);
			
			//If the table exist then
			if (mysqli_num_rows($result) > 0) {
				//Assign the array of information to the $users variable
				$user = mysqli_fetch_array($result);
				
				//Checks to see if the user inputed password matches the hashed password from the users table
				if (password_verify($password, $user['password'])) {
					
					//Checks to make sure that the current logged in user is the one deleting the account
					if ($username == $_SESSION['username']) {
						
						//If there is a reason given then
						if ($reason) {
							//Insert the deleted user into the deleted_users table
							$query = "INSERT INTO deleted_users (id, user, email, reason) VALUES ('$user_id', '$user_username', '$user_email', '$reason')";
							mysqli_query($conn, $query);
							
							//Then actually delete the user from the users table
							$query_2 = "DELETE FROM users WHERE id = '$user_id'";
							mysqli_query($conn, $query_2);
							
							// Unset all of the session variables
							$_SESSION = array();
 
							// Destroy the session.
							session_destroy();
 
							// Redirect to login page
							header('location: login.php');
							exit();
						}
					}else{
						array_push($errors, "Wrong username combination");
					}
				}else{
					array_push($errors, "Wrong password combination");
				}
			}else{
				array_push($errors, "This account does not exist");
			}
		}
	}
?>