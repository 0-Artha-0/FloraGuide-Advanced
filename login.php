<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            /* use vh */
            background: url("FloraGuide-main/Images/plant.jpg") no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 300px;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #aaa;
            font-size: 14px;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background: #0056b3;
        }

        .register-link {
            margin-top: 15px;
            display: block;
            font-size: 14px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php
    session_start();

    $message = "";

    // Checks if a login failed message is set
    if (isset($_SESSION["message"])) {
        $message .= $_SESSION["message"];

        // display an alert message
        echo '<script> alert("' . $message . '"); </script>';

        // reset the error message
        unset($_SESSION["message"]);
    }

    // reset the session
    session_destroy();
    ?>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login_check.php" method="POST">
            <label>Username:</label>
            <input type="text" name="loginUsername" required>

            <label>Password:</label>
            <input type="password" name="loginPassword" required>

            <input type="submit" value="Login">
        </form>

        <div class="register-link">
            Don't have an account? <a href="registration.php">Register</a>
        </div>
    </div>

</body>

</html>