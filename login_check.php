<?php
// include the database connection constants
include "connecting.php";
session_start();

// function to validate the login credentials
// returns user_id and username when successful
// returns error message if not
function authenticateUser($connection, $username, $password)
{
    $errors = "";
    // validate form variables are not empty
    if (empty($username))
        $errors .= "Username is required.\\n";

    if (empty($password))
        $errors .= "Password is required.";

    // If errors is not empty, handle errors for missing fields 
    if (!empty($errors))
        return array(false, $errors);

    // Create salt from username
    $salt = substr($username, 0, 2);
    // Create an encrypted_pw composed of password + salt
    $crypted_pw = crypt($password, $salt);

    // Look for matching credentials in the system
    $query = "SELECT account_id, username, password_txt FROM account
                WHERE username = '$username'
                AND password_txt = '$crypted_pw'";
    $result = $connection->query($query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        return array(true, $user['account_id'], $user['username']);
    }

    // Return message for a failed authentication
    $errors .= "Failed to connect to application under '{$username}'";
    return array(false, $errors);
}


$loginUsername = $_POST['loginUsername'];
$loginPassword = $_POST['loginPassword'];

$authResult = authenticateUser($connection, $loginUsername, $loginPassword);

// check if the result of authentication is true or false
if ($authResult[0]) {
    // Successfull login
    // Store user info in session
    $_SESSION['user_id'] = $authResult[1];
    $_SESSION['loginUsername'] = $authResult[2];
    $_SESSION["loginIP"] = $_SERVER["REMOTE_ADDR"]; //this is to remember the host

    // Redirect to the home page (index.php)
    header("Location: FloraGuide-main/index.php");
    exit;
} else {
    // Failed login
    // store failed login message in session, and reload login.php page
    $_SESSION['message'] = $authResult[1];
    header("Location: login.php");
    exit;
}

?>