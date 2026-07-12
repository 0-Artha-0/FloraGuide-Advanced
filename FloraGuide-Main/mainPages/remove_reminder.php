<?php
session_start();

// Check if user id is set, otherwise, logout
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login.php");
    exit;
}

// Store user id
$user_id = $_SESSION["user_id"];

// Establish connection with database
include '../../connecting.php';


// Handle form submission to remove a reminder
if (isset($_POST['remove'])) {
    // Retrieve the submitted reminder_id
    $reminder_id = $_POST['reminder_id'];

    // Query database to delete that reminder
    $query = "DELETE FROM reminder WHERE reminder_id = '{$reminder_id}'";
    $result = $connection->query($query);

    // Verify deleting reminder ran successfully
    if ($result && mysqli_affected_rows($connection) > 0) {
        // After delete successful, reload page to show the rest of the reminders
        header("Location: reminders.php");
        exit();
    } else
        echo "<script> alert('Failed to remove reminder. Please try again');</script>";

}
?>