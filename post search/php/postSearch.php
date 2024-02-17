<?php

require_once 'PostQueries.php';

session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['userName'])) {
    header("Location: ../../log in system/php/login-interface.php");
    exit();
}
if(isset($_POST['submit'])){

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $date = $_POST['date'];
}

try {
    $result = PostQueries::search($name, $title, $category, $date);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

header('Location: postComment.php');

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/postSearch.css">
    <title>postSearch</title>
</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href="HomePage.html">Mingle!</a></div>
            <ul>
                <li><a href="#" target="_blank" ><?php echo $_SESSION['userName']; ?></a></li>
            </ul>
        </div>
    </nav>
    <div class="formdiv">
        <h1>Post Search</h1>
        <form action="" method="post" >

            <label class="option" name="name" for="">Name<input class="name" name="name" type="text" ></label><br>
            <label class="option" name="title" for="">Title<input class="title" name="title" type="text" ></label><br>
            <label for="" class="option">category<select name="category" id="">
                <option name="category" value=""></option>
                <option name="category" value="1">Politics</option>
                <option name="category" value="2">Nowadays</option>
                <option name="category" value="3">Education</option>
                <option name="category" value="4">science</option>
            </select></label><br>
            <label class="option" name="date" for="">Date<input type="date" name="date"></label><br>
    
            <ul>
                <li><a target="_blank"><button type="submit" name="submit" class="search">Search</button></a></li>
            </ul>

        </form>
    </div>
</body>
</html>