<?php
include 'connecting.php';

function newUser($connection, $username, $email, $phone, $password)
{
	$errors = "";
	// verify form variables are not empty
	if (empty($username))
		$errors .= "Username is required.\\n";

	if (empty($email))
		$errors .= "Email is required.\\n";

	if (empty($phone))
		$errors .= "Phone is required.\\n";

	if (empty($password))
		$errors .= "Password is required.";

	// If errors is not empty, handle errors for missing fields 
	if (!empty($errors))
		return array(false, $errors);

	// Retrieve last available account_id for new entry
	$query = "SELECT max(account_id) FROM account";
	$result = $connection->query($query);
	$account_id = mysqli_fetch_row($result)[0] + 1;

	// Create password salt -> encrypted password
	$salt = substr($username, 0, 2);
	$crypted_pw = crypt($password, $salt);

	// Create a new account user 
	$query = "INSERT INTO account SET 
					account_id = '$account_id',
					username = '$username',
					email = '$email',
					phone_number = '$phone',
					password_txt = '$crypted_pw'";

	// Try inserting new account
	try {
		$result = $connection->query($query);
	} catch (Exception $e) {
		// empty block to avoid redirecting to error pages
		// and reload registration page with failed message instead
	}
	// Return true if insert query is successful, and false otherwise
	if ($result)
		return array(true);
	else
		$errors .= "Failed to register a new account under '{$username}. Please try again.'";
	return array(false, $errors);
}

// retrieve new user credentials
$regUsername = $_POST['regUsername'];
$regEmail = $_POST['regEmail'];
$regPhone = $_POST['regPhone'];
$regPassword = $_POST['regPassword'];

// Try to register user and retrieve success status
$is_registered = newUser($connection, $regUsername, $regEmail, $regPhone, $regPassword);

if ($is_registered[0]) {
	// Successful account creation
	// Redirect to login page
	header('Location: login.php');
	exit;
} else {
	session_start();
	// Failed account registration
	// store failed message in session, and redirect to registration.php page again
	$_SESSION['message'] = $is_registered[1];
	header("Location: registration.php");
	exit;
}
?>