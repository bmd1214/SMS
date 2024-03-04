<?php
require_once 'postManager.php';

// instantiate the class
$postManager = new PostManager();
$userName = $postManager->getUserName();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/posts.css">
    <title>postComment</title>
</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href="../../../Assignment 3/homePage/php/HomePage.php">Mingle!</a></div>
            <ul>
                <li><a href="#" target="_blank"><?php echo $userName ?></a></li>
            </ul>
        </div>
    </nav>

    <?php echo $postManager->getPostsHTML(); ?> <!-- Display the generated HTML for posts -->
</body>
</html>
