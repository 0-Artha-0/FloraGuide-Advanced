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

// Handle form submission to add a new reminder
if (isset($_POST['save'])) {
    // Retrieve the last reminder_id
    $query = "SELECT max(reminder_id) FROM reminder";
    $result = $connection->query($query);
    $reminder_id = mysqli_fetch_row($result)[0] + 1;

    // Retrieve form variables to insert to database
    // Escape special characters to avoid query errors
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $note = mysqli_real_escape_string($connection, $_POST['note']);
    $datetime = $_POST['datetime'];
    $frequency = $_POST['frequency'];
    $type = $_POST['type'];
    $plant_id = $_POST['plant_id'];
    $is_active = $_POST['is_active'];

    $query = "INSERT INTO reminder 
            VALUES ('{$reminder_id}', '{$title}', '{$note}', '{$datetime}', 
            '{$frequency}', '{$type}', '{$is_active}', '{$user_id}', '{$plant_id}')";
    $result = $connection->query($query);

    // Verify inserting reminder ran successfully
    if ($result && mysqli_affected_rows($connection) > 0) {
        // After insert, reload page to show new reminder
        header("Location: reminders.php");
        exit();
    } else
        echo "<script> alert('Failed to save new reminder. Please try again');</script>";

} ?>