<?php
use MyNamespace\Comment;
require_once 'CommentClass.php';
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['userName'])) {
    header("Location: ../../../Assignment 3/log in system/php/");
    
    exit();
}

$userName = $_SESSION['userName'];
$postId = $_GET['postId'];
 
if(isset($_POST['submit'])){
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $comment = $_POST['comment'];
        $userName = $_SESSION['userName'];
        
    } else {
        echo "There is a problem connecting with the server!";
        exit;
    }

    if (!empty($comment)) {
        try {
            $comm = new Comment($comment, $userName, $postId);
            
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    // header('Location: ../../post search/postComment.php');
    // exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/commentPage.css">
    <title>CommentPage</title>
</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href="HomePage.html">Mingle!</a></div>
            <ul>
                <li><a href="#" target="_blank" ><?php echo $userName; ?></a></li>
            </ul>
        </div>
    </nav>
    <div class="formdiv">
        <h1>Comments</h1>
        <form action="" method="post">
            <div class="comment_section">
            <label class="option" for="">Name<input class="input2" type="text" readonly></label><br>
            <label class="option" for="">comment<input class="input1" type="text" readonly></label><br>
            </div>
            <div class="comment_section">
                <label class="option" for="">Name<input class="input2" type="text" readonly></label><br>
                <label class="option" for="">comment<input class="input1" type="text" readonly></label><br>
            </div>
            <div class="comment_section">
                <label class="option" for="">Name<input class="input2" type="text" readonly></label><br>
                <label class="option" for="">comment<input class="input1" type="text" readonly></label><br>
            </div>
            <div class="comment_section">
                <label class="option" for="">Name<input class="input2" type="text" value="<?php echo $userName; ?>" readonly></label><br>
                <label class="option" for="">comment<input class="input1" name="comment" type="text"></label><br>
            </div>
            <ul>
                <li><button class="button2" name="submit" type="submit">Comment</button></li>
                <li><button class="button2" type="reset">Clear</button></li>
            </ul>
        </form>
    </div>
</body>
</html>