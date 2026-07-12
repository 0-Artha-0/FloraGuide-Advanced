<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Plants Directory</title>
    <link rel="stylesheet" type="text/css" href="../styles/directory.css">
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

    <div class="content">
        <form class="form" method="get" action="directory.php">
            <p>
                <label for="plantSearch">
                    <h3>Try Looking up your Plant:</h3>
                    <input type="search" id="plantSearch" name="searched_plant"
                        placeholder="type or search the plant name" size="50" list="plants">
                    <br>
                    <datalist id="plants">
                        <?php
                        // establish connection with database
                        include "../../connecting.php";

                        // script to retrieve available plants in database                        
                        $query = "SELECT plant_id, common_name, scientific_name FROM plant";

                        $available_plants = $connection->query($query);

                        while ($plant = mysqli_fetch_array($available_plants))
                            echo "<option value=\"{$plant['common_name']}\"></option>"
                                ?>
                        </datalist>
                    </label>
                </p>
                <p>
                    <button type="submit" id="search">Search</button>
                </p>
            </form>

            <?php

                        // Check first if any search form was submitted
                        if (isset($_GET['searched_plant'])) {
                            $plant_name = mysqli_real_escape_string($connection, $_GET['searched_plant']);
                            $query = "SELECT plant_id, scientific_name, common_name, image_path FROM plant WHERE common_name='$plant_name'";
                        } else
                            // else, just retrieve all plants in the database
                            $query = "SELECT plant_id, scientific_name, common_name, image_path FROM plant";

                        // run the query
                        $result = $connection->query($query);

                        // check if query ran successfully
                        if (!$result) {
                            die("Error in retrieving plants: " . mysqli_error($connection));
                        }


                        // start session to store plant_id in case a user clicks a plant
                        session_start();

                        // display a grid of all returned plants and their links
                        echo '<div class="plant-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; padding: 20px;">';

                        while ($row = mysqli_fetch_array($result)) {
                            echo '<div class="plant-card" style="background: rgba(255, 255, 255, 0.5); border-radius: 10px; padding: 15px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">';

                            echo "<img src='{$row['image_path']}' alt='{$row['common_name']} Icon' style='max-width: 100%; height: 200px; object-fit: cover; border-radius: 5px;'>";

                            echo '<h3>' . $row['common_name'] . '</h3><p><em>' . $row['scientific_name'] . '</em></p>';

                            echo "<form action='individual_plant.php' method='POST'>
                            <input type='hidden' name='plant_id' value='{$row[0]}'>
                            <button type='submit' style='background: green; color: white; border: none;
                            padding: 10px 20px; border-radius: 5px; cursor: pointer;'>View Details</button>
                        </form></div>";
                        }
                        echo '</div>';
                        ?>
    </div>

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