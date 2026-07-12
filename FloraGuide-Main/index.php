<?php
session_start();

$message = "";

if (isset($_SESSION["loginUsername"])) {
    $message .= "Welcome {$_SESSION["loginUsername"]} to our Application!";
}

if (isset($_SESSION["message"])) {
    $message .= $_SESSION["message"];
    unset($_SESSION["message"]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>FloraGuide HomePage</title>
    <link rel="stylesheet" type="text/css" href="styles/homeDesign.css">
</head>

<body>
    <nav class="linksbar">
        <ul>
            <li><a href="index.php">Home Page</a></li>
            <li><a href="mainPages/directory.php">Plants Directory</a></li>
            <li><a href="mainPages/collections.php">My Plant Space</a></li>
            <li><a href="mainPages/reminders.php">Plant Reminders</a></li>
            <li><a href="mainPages/about.html">About Us</a></li>
            <li><a href="../logout.php">Logout</a></li>


        </ul>

        <img src="Images/logo.png" width="70" alt="FloraGuide logo">
        <h1><strong>FloraGuide</strong></h1>
    </nav>

    <div class="content">
        <header>
            <?php if (!empty($message)): ?>
                <div
                    style="background-color: rgb(255,255,255, 0.8); width: 70%; color: black; padding: 10px; margin: 20px; border-radius: 5px; text-align: center; justify-self:center;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <h1>FloraGuide<img src="Images/logo.png" width="100" alt="FloraGuide logo"></h1>
            <br>
            <h2> Cultivating Your Green Thumb, One Plant at a Time.</h2>
        </header>

        <form method="get" action="mainPages/directory.php">
            <p>
                <label for="plantSearch">
                    <h3>Try Looking up your Plant:</h3>
                    <input type="search" id="plantSearch" name="searched_plant"
                        placeholder="type or search the plant name" size="50" list="plants">
                    <br>
                    <datalist id="plants">
                        <?php
                        // script to retrieve available plants in database
                        // Establish connection with database
                        include "../connecting.php";

                        $query = "SELECT plant_id, common_name FROM plant";

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