<?php
session_start();

// Clear session variables (user credentials and info)
$_SESSION = array();

// Destroy session
session_destroy();

// Redirect back to the login page
header("Location: login.php");

?>