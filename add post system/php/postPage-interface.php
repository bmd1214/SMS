<?php
require_once 'Post.php';

session_start();

// Check if the user is not logged in, redirect to the login page
if(!isset($_SESSION['userName'])) {
    header("Location: ../../log in system/php/login-interface.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    //check if the id isset or not
    if(isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    }
    else{
        echo "there is somthing wrong with id";
        exit;
    }
        $title = $_POST['title'];
        $category = $_POST['category'];
        $post = $_POST['post'];
    

    $newPost = new Post($title, $category, $post);

    // inserting data in the table post and sending the user id
    $newPost->insertPost($userId);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/postPage.css">
    <title>post</title>
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
        <h1>Add Post</h1>
        <form action="" method="post">
            <label class="option" for="" >title<input class="input1" type="text" name="title"></label><br>
            <label class="option" for="">Date<input class="input1" type="text" readonly value="<?php echo $date = date("Y-m-d"); ?>"></label><br>
            <label for="" class="option">category<select name="category" id="">
                <option name="category" value=""></option>
                <option name="category" value="1">Politics</option>
                <option name="category" value="2">Nowadays</option>
                <option name="category" value="3">Education</option>
                <option name="category" value="4">science</option>
            </select></label>
            <textarea type="text" name="post" ></textarea>
            <label for="" class="option">Upload Media</label>
            <input type="file" name="imageupload" class="file-input">
            <ul>
                <li><a href="#"><button class="button2" type="submit" value="submit">Post</button></a></li>
                <li><a href="#"><button class="button2" type="reset">Clear</button></a></li>
            </ul>
        </form>
    </div>
</body>
</html>


