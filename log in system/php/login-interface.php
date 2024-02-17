<?php
session_start();

require_once 'user.php';

// Check if the user is already logged in, redirect to home page if true
if(isset($_SESSION['userName'])) {
    header("Location: home.php");
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['userName'];
    $password = $_POST['password'];

    $user = new User($username, $password);
    if ($name= $user->userExist() ) {
        // Set session variables
        $_SESSION['userName'] = $name;

        // Redirect to home page after successful login
        header("Location: ../../homePage/php/HomePage.php");
        exit();
    } else {
        $mess = "Invalid username or password";
    }

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../CSS/login.css" media="screen">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <nav class="navbar">
        <div class="navdiv">
            <div class="logo">Mingle!</div>
            <ul>
                <li><a href="../../signup system/php/signup-interface.php" target="_self"><button>SignUp</button></a></li>
                <li><a href="../../homePage/php/HomePage.php" target="_blank"><button>Home</button></a></li>
                <li><a href="#" ><button>About Us</button></a></li>
            </ul>
        </div>
        <p><?php if(isset($mess)) echo $mess; ?></p>
    </nav>


    <div class="box1">
        <h1>Log in</h1>
        <form class="box" method="post" action=""  >
            <label for="">User Name</label>
            <input type="text" name="userName" placeholder="">
            <label for="">Password</label>
            <input type="Password" name="password" placeholder="" >
            <input type="submit" name="" value="Log in">
        </form>
    </div>
    <p>Didn't Sign Up? <a href="../../signup system/php/signup-interface.php" target="_self">Signup</a></p>
</body>
</html>


