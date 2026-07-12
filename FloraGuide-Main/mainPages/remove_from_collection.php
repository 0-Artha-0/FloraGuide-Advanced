<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

// Include database constants
include "../../connecting.php";

// Check plant id is recieved to remove
if (isset($_POST['plant_id'])) {

    // Retrieve user id and plant id 
    $user_id = $_SESSION['user_id'];
    $plant_id = $_POST['plant_id'];

    // Query database to delete this plant from user collection 
    $query = "DELETE FROM collections 
    WHERE account_id = '$user_id' AND plant_id = '$plant_id'";
    $result = $connection->query($query);

    // Check if query ran successfully
    if ($result) {
        $_SESSION['message'] = "Plant removed from collection successfully!";
    } else {
        $_SESSION['message'] = "Error removing plant: " . mysqli_error($connection);
    }
}

header("Location: collections.php");
exit;
?>