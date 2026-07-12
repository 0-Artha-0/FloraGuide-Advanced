<!DOCTYPE html>
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

?>
<html>

<head>
    <meta charset="UTF-8" />
    <title>FloraGuide HomePage</title>
    <link rel="stylesheet" type="text/css" href="../styles/reminders.css">
    <style>
        :root {
            --color1: rgb(189, 203, 109);
        }

        h1 {
            text-align: center;
            font-size: 3em;
        }

        h3 {
            text-align: center;
            padding: 100px;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            min-height: 80vh;
        }

        .reminder-add {
            padding: 20px 30px;
            display: flex;
            width: 80%;
            background-color: var(--color1);
            border-radius: 15px;
            box-shadow: 0px 0px 5px 1px;
            justify-content: space-between;
            margin-left: auto;
            margin-right: auto;
            margin-top: 130px;
            margin-bottom: 15px;
            align-content: center;
        }

        .reminder-button {
            font-family: Papyrus, Courier New, Georgia, monospace, Serif;
            color: white;
            font-weight: bolder;
            text-shadow: 0px 0px 2px white;
            font-size: 15pt;
            padding: 5px;
            padding-right: 10px;
            padding-left: 10px;
            border-radius: 10px;
            background-color: green;
            box-shadow: 0px 2px 2px darkgreen;
            border: 0;
            width: 30%;
        }

        .reminder-prompt {
            width: 40%;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 20pt;
            font-weight: bold;
            color: black;
            align-content: center;
        }

        .reminder {
            padding: 20px 30px;
            display: flex;
            width: 80%;
            background-color: rgb(255, 255, 255, 0.5);
            border-radius: 15px;
            box-shadow: 0px 0px 3px 1px #000000ff;
            background-color: rgba(0, 0, 0, 0.7);
            margin-left: auto;
            margin-right: auto;
            margin-top: 15px;
            margin-bottom: 15px;
            align-items: center;
            justify-content: space-between;
        }

        .reminder-tag {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-weight: bold;
            font-size: large;
            color: white;
        }

        .reminder-form {
            z-index: 9999;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            justify-content: center;
            display: none;
            flex-direction: column;
            margin: 30px auto;
            width: 50%;
            height: 90%;
            background: rgb(0, 0, 0, 0.8);
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 5px #aaa;
            align-items: center;
        }

        .reminder-form div,
        .reminder-form label {
            display: flex;
            flex-direction: row;
            padding: 10px;
            align-items: center;
            gap: 20px;
            width: 80%;
            color: aliceblue;
        }

        .reminder-form input,
        .reminder-form select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #aaa;
            font-size: 14px;
        }
    </style>

</head>

<body>
    <nav class="linksbar">
        <ul>
            <li><a href="../index.php">Home Page</a></li>
            <li><a href="../mainPages/directory.php">Plants Directory</a></li>
            <li><a href="../mainPages/collections.php">My Plant Space</a></li>
            <li><a href="../mainPages/reminders.php">Plant Reminders</a></li>
            <li><a href="../mainPages/about.html">About Us</a></li>
            <li><a href="../../logout.php">Logout</a></li>
        </ul>

        <img src="../Images/logo.png" width="70" alt="FloraGuide logo">
        <h1><strong>FloraGuide</strong></h1>
    </nav>



    <main class="main-content">
        <!-- Display reminders -->
        <div class="reminder-add">
            <span class="reminder-prompt">Set a reminder !</span>
            <button class="reminder-button" id="showFormBtn">Add New Reminder</button>
        </div>
        <?php
        // Fetch and display reminders for this account
        $query = "SELECT * FROM reminder WHERE account_id ='{$user_id}'";
        $reminders = $connection->query($query);

        // loop through reminders list and display them
        if (mysqli_num_rows($reminders) > 0)
            while ($rem = mysqli_fetch_array($reminders)) {
                $formattedDate = date("F j, Y g:i A", strtotime($rem['reminder_time']));
                echo '<div class="reminder">';
                echo '<div class="reminder-tag">' . $rem['reminder_title'] . ' - ' . $rem['reminder_note'] . '</div>';
                echo '<div class="reminder-tag">(' . $formattedDate . ')</div>';
                echo '<form action="remove_reminder.php" method="post" onsubmit="return confirm(\'Are you sure you want to remove the reminder?\')";>
                        <button type="submit" name="remove" class="reminder-button" style="background-color:darkred;box-shadow: 0px 2px 2px black; font-size: 10pt; width:100%;">Remove Reminder</button>
                        <input type="hidden" name="reminder_id" value="' . $rem['reminder_id'] . '"></form>';
                echo '</div>';
            }
        ?>
        <form action="insert_new_reminder.php" class="reminder-form" id="reminderForm" method="post">
            <label>Title
                <input type="text" required name="title">
            </label>

            <label>Description
                <input type="text" required name="note">
            </label>

            <label>Datetime
                <input type="datetime-local" required name="datetime">
            </label>

            <label>Frequency
                <select name="frequency">
                    <option value="" selected disabled>Select the frequency</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </label>

            <label>Type
                <select name="type" required>
                    <option value="" selected disabled>Select the reminder medium</option>
                    <option value="email">Email</option>
                    <option value="sms">SMS</option>
                    <option value="push">Push</option>
                    <option value="in_app">In_App</option>
                </select>
            </label>

            <label>Plant
                <select name="plant_id">
                    <option value="" selected disabled>Select the plant</option>
                    <?php

                    // retreive plant names of user's plant collection
                    $query = "SELECT P.plant_id, P.common_name FROM collections C, plant P WHERE C.account_id='{$user_id}' AND C.plant_id = P.plant_id";
                    $plants_collection = $connection->query($query);

                    // Loop through collection and display options
                    if (mysqli_num_rows($plants_collection) > 0)
                        while ($row = mysqli_fetch_array($plants_collection)) {
                            echo "<option value='{$row['plant_id']}'>{$row["common_name"]}</option>";
                        } else {
                        echo "<option value='None'>Your collection is empty</option>";
                    }
                    ?>
                </select>
            </label>

            <input type="hidden" name="is_active" value="TRUE">
            <div>
                <button type="submit" name="save" class="reminder-button"
                    style="background:green;width: 100%;margin-right:10px;">Save</button>
                <button type="button" id="cancelBtn" class="reminder-button"
                    style="background:gray; width: 100%;">Cancel</button>
            </div>
        </form>
    </main>

    <script>
        // JS functions to control visibility of a new reminders form
        document.getElementById('showFormBtn').onclick = function () {
            document.getElementById('reminderForm').style.display = 'flex';
        };
        document.getElementById('cancelBtn').onclick = function () {
            document.getElementById('reminderForm').style.display = 'none';
        };
    </script>


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