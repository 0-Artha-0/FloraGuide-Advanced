<?php
session_start();

// Exit if user id is not set-> means they don't have access and should be logged out
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

// Include database constants
include "../../connecting.php";

// Exit if no plant is selected from form
if (!isset($_POST['plant_id'])) {
    exit("No plant selected!");
}

// Store selected plant id
$plant_id = $_POST['plant_id'];

// Query database to return all info of the selected plant
$query = "SELECT * FROM plant WHERE plant_id = '$plant_id'";
$result = $connection->query($query);

// Verify query returned the requested info
if (!$result || mysqli_num_rows($result) == 0) {
    die("Plant not found!");
}

$row = mysqli_fetch_array($result);

// Runs if the page reloads to add the plant to the collection of the user
if (isset($_POST['add_to_collection'])) {
    // Retrieve user id
    $user_id = $_SESSION['user_id'];

    // Check if plant is already in the collections of the user
    $checkQuery = "SELECT * FROM collections 
                    WHERE account_id = '$user_id' 
                    AND plant_id = '$plant_id'";

    $checkResult = $connection->query($checkQuery);

    // If returned array result is empty, insert the plant to collection
    if ($checkResult && mysqli_num_rows($checkResult) == 0) {
        $insertQuery = "INSERT INTO collections 
            SET account_id = '$user_id',
            plant_id = '$plant_id'";
        $insertResult = mysqli_query($connection, $insertQuery);

        // Save the status of insert query to a message
        if ($insertResult) {
            $message = "Plant added to your collection!";
        } else {
            $message = "Error adding plant to collection: " . mysqli_error($connection);
        }
    } else {
        // Plant is already in collection
        // Save confirmation to a message
        $message = "Plant is already in your collection!";
    }

    // Display the status of add_to_collection request in a dialog
    echo "<script>alert('$message')</script>";

    // Embedded php code below in html fills all guide fields with its respective info from retrieved result
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $row[2]; ?> - FloraGuide</title>
    <link rel="stylesheet" type="text/css" href="../styles/PlantDesign.css">
</head>

<body>
    <nav class="linksbar">
        <ul>
            <li><a href="../index.php">Home Page</a></li>
            <li><a href="directory.php">Plants Directory</a></li>
            <li><a href="collections.php">My Plant Space</a></li>
            <li><a href="reminders.php">Plant Reminders</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="../../logout.php">Logout</a></li>
        </ul>

        <img src="../Images/logo.png" width="70" alt="FloraGuide logo">
        <h1><strong>FloraGuide</strong></h1>
    </nav>

    <div class="content" style="margin-bottom: 200px;">
        <br><br>
        <div class="image">
            <img src="<?php echo $row['image_path']; ?>" height="400" alt="<?php echo $row[2] . 'image'; ?>">

            <section style="margin: 0; padding: 0 0 0 10px;">
                <h1 id="names"><?php echo $row['common_name']; ?> <em>(<?php echo $row['scientific_name']; ?>)</em></h1>
                <div class="intro">
                    <?php echo $row['intro']; ?>
                    <br><br>

                    <form method="POST">
                        <button type="submit" name="add_to_collection" class="collect">Add to my collection!</button>
                        <input type="hidden" name="plant_id" value="<?= $plant_id ?>">
                    </form>
                </div>
            </section>
        </div>

        <section class="guide">
            <h2><img src="../Images/icons/signpost.png" width="35"> In this guide:</h2>

            <ul style="padding: 0px 50px; text-decoration: underline;">
                <li><a href="#watering">Watering Frequency & Technique</a></li>
                <li><a href="#soil">Appropriate Soil</a></li>
                <li><a href="#light">Needed Light Amount</a></li>
                <li><a href="#temp">Temperature Conditions</a></li>
                <li><a href="#fertilization">Fertilization Times</a></li>
                <li><a href="#pruning">Pruning</a></li>
                <li>Additional info:
                    <ul>
                        <li><a href="#humidity">Humidity</a></li>
                        <li><a href="#air">Air Circulation</a></li>
                        <li><a href="#pests">Pest Management</a></li>
                        <li><a href="#repot">Repotting</a></li>
                    </ul>
                </li>
                <li><a href="#resources">Additional Resources</a></li>
            </ul>
        </section>

        <section id="watering" style="background-color: rgba(197, 237, 250, 0.6);">
            <h3><img src="../Images/icons/watering.png" width="35" alt="watering icon"> Watering</h3>
            <span><?php echo $row['watering']; ?></span>
            <h4>Frequency</h4>
            <span style="padding: 30px;"><?php echo $row['watering_frequency']; ?></span>
            <h4>Technique</h4>
            <span style="padding: 30px;"><?php echo $row['watering_technique']; ?></span>
        </section>

        <section id="soil">
            <h3><img src="../Images/icons/soil.png" width="35" alt="soil icon"> Soil</h3>
            <span><?php echo $row['soil']; ?></span>
        </section>

        <section id="light" style="background-color: rgba(255, 255, 127, 0.5);">
            <h3><img src="../Images/icons/light.png" width="35" alt="light icon"> Light</h3>
            <span><?php echo $row['light']; ?></span>
        </section>

        <section id="temp">
            <h3><img src="../Images/icons/temperature.png" width="35" alt="temperature icon"> Temperature</h3>
            <span><?php echo $row['temperature']; ?></span>
        </section>

        <section id="fertilization" style="background-color: rgba(40, 114, 0, 0.45);">
            <h3><img src="../Images/icons/fertilizer.png" width="35" alt="liquid fertilizer icon"> Fertilization</h3>
            <span><?php echo $row['fertilization']; ?></span>
        </section>

        <section id="pruning">
            <h3><img src="../Images/icons/shears.png" width="35" alt="pruning shears icon"> Pruning</h3>
            <span><?php echo $row['pruning']; ?></span>
        </section>

        <div style="background-color: rgba(86, 255, 201, 0.372);">
            <section id="humidity">
                <h3><img src="../Images/icons/humidity.png" width="35" alt="humidity dew point icon"> Humidity</h3>
                <span><?php echo $row['humidity']; ?></span>
            </section>

            <section id="air">
                <h3><img src="../Images/icons/air.png" width="35" alt="air icon"> Air Circulation</h3>
                <span><?php echo $row['air_circulation']; ?></span>
            </section>
        </div>

        <section id="pests">
            <h3><img src="../Images/icons/bug.png" width="35" alt="pest icon"> Pest Management</h3>
            <span><?php echo $row['pest_management']; ?></span>
        </section>

        <section id="repot">
            <h3><img src="../Images/icons/pot.png" width="35" alt="potted plant icon"> Repotting</h3>
            <span><?php echo $row['repotting']; ?></span>
        </section>

        <section id="resources">
            <h3><img src="../Images/icons/add.png" width="35"> Additional Resources</h3>

            <ul>
                <?php

                // Retrieve resource records associated with the requested plant
                $resources_query = "SELECT * FROM resources WHERE plant_id = $plant_id";
                $resources_result = $connection->query($resources_query);

                while ($res = mysqli_fetch_array($resources_result)) {
                    echo "<li><a href='" . $res['resource_href'] . "'>"
                        . $res['resource_name'] . "</a></li>";
                }
                ?>
            </ul>
        </section>
    </div>

    <footer>
        <h6><a href="mailto:U21101466@sharjah.ac.ae">contact us</a></h6>
        <!-- Footer content -->
    </footer>
</body>

</html>