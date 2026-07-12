<?php
session_start();

// Check if user_id is set, otherwuise user is logged out and must be redirected to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

// Include database constants
include "../../connecting.php";

// Retrieve user id from session
$user_id = $_SESSION['user_id'];


// Query database to retrieve the list of plants ids saved in user collection
$query = "SELECT plant_id FROM collections WHERE account_id = '$user_id'";
$result = $connection->query($query);

// Initialiaze array to store the plant  to 
$plants = array();

// Check if query result is empty
if ($result && mysqli_num_rows($result) > 0) {

    // Loop through each plant id and store its relative info in array
    while ($row = mysqli_fetch_row($result)) {
        $plant_id = $row[0];

        $plantQuery = "SELECT plant_id, common_name, scientific_name, sticker_path 
                      FROM plant 
                      WHERE plant_id = '$plant_id'";
        $plantResult = $connection->query($plantQuery);

        // Verify retrieved plant info array is not empty
        if ($plantResult && mysqli_num_rows($plantResult) > 0) {
            $plantRow = mysqli_fetch_array($plantResult);

            // append plant to the global plants array
            $plants[] = array(
                'plant_id' => $plantRow['plant_id'],
                'common_name' => $plantRow['common_name'],
                'scientific_name' => $plantRow['scientific_name'],
                'sticker_path' => $plantRow['sticker_path']
            );
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>My Plant Collection</title>
    <link rel="stylesheet" type="text/css" href="../styles/space.css">
    <style>
        main {
            min-height: 100vh;
        }

        .collection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 140px 20px 20px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .plant-card {
            /* background: rgba(255, 255, 255, 0.9); */
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
            transition: transform 0.3s ease;
        }

        .plant-card:hover {
            transform: translateY(-5px);
        }

        .plant-card img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .plant-name {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 5px;
            color: #2d5016;
        }

        .scientific-name {
            font-style: italic;
            color: #666;
            margin-bottom: 10px;
        }

        .empty-collection {
            text-align: center;
            padding: 140px 20px 20px 20px;
            font-size: 1.5em;
            color: #666;
        }

        .remove-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .remove-btn:hover {
            background: #cc0000;
        }
    </style>
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

    <main>
        <?php

        // Check if plants array is empty (no plants in user collection)
        if (empty($plants)) {
            echo '<div class="empty-collection">
                <h2>Your collection is empty</h2>
                <p>Start by adding plants from the <a href="directory.php">Plants Directory</a></p>
              </div>';
        } else {
            // Loop through plants list and display their stickers
            echo '<div class="collection-grid">';
            foreach ($plants as $plant) {
                echo '<div class="plant-card">
                    <img src="' . $plant['sticker_path'] . '" alt="' . $plant['common_name'] . '">
                    <div class="plant-name">' . $plant['common_name'] . '</div>
                    <div class="scientific-name">' . $plant['scientific_name'] . '</div>
                    <form method="POST" action="remove_from_collection.php" onsubmit="return confirm(\'Remove this plant from your collection?\');">
                        <input type="hidden" name="plant_id" value="' . $plant['plant_id'] . '">
                        <button type="submit" class="remove-btn">Remove</button>
                    </form>
                  </div>';
            }
            echo '</div>';
        }
        ?>
    </main>

    <footer>
        <h6><a href="mailto:U21101466@sharjah.ac.ae">contact us</a></h6>
        <p style="font-size: 10pt">
            Done by:
            <br>
            Huda Bakather - Computer Science - U21101466
            <br>
            Maitha Adel - Computer Science - U22100299
            <br>
            Shaffa Zeenath Abdul Nazeer - Computer Science - U22101031
            <br>
            Aaliya Asif - IT & Multimedia - U22100756
            <br>
            Roudha Abdulla - IT & Multimedia - U22101256
        </p>
    </footer>
</body>

</html>