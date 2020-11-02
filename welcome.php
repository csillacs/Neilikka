<?php


$link = mysqli_connect("127.0.0.1", "root", "", "neilikka");
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
// echo "Success: A proper connection to MySQL was made! ";
// echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL . "<br>";
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>



<!DOCTYPE html>

<html>

<head>
    <title>Puutarhaliike Neilikka</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <script src="script.js"></script>
</head>

<body>
    <div class="header"> Puutarhaliike Neilikka</div>
    <div class="background">
        <div class="topnav" id="myTopnav">
            <a href=index.html>Etusivu</a>
            <div class="dropdown">
                <button class="dropbtn">Tuotteet
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="sisäkasvit.html" target="_self">Sisäkasvit</a>
                    <a href="ulkokasvit.html" target="_self">Ulkokasvit</a>
                    <a href="tyokalut.html" target="_self">Työkalut</a>
                    <a href="kasvienhoito.html" target="_self">Kasvien hoito</a>

                </div>
            </div>
            <a href="myymalat.html" target="_self">Mymäälät</a>
            <a href="tietoa.html" target="_self">Tietoa meistä</a>
            <a href="otayht.html" target="_self">Ota yhteyttä</a>
            <a href="register.php" target="_self" class="active">Kirjautuminen</a>

            <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
        </div>


        <!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head> -->

        <div class="page-header">
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        </div>
        <fieldset>

            <p>
                <a href="reset_password.php" class="btn btn-warning">Reset Your Password</a>
                <br>
                <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
            </p>
        </fieldset>

        <footer>
            @Puutarhaliike Neilikka Finland Oy 2020
        </footer>
</body>

</html>