<?php
require_once 'PostQueries.php';

session_start();

$postsHTML = ''; // initialize an empty string to store HTML for posts

$userName = $_SESSION['userName'];
if (isset($_SESSION['search_result'])) {
    $searchResult = $_SESSION['search_result'];
    

    // iterate over the search result array
    foreach ($searchResult as $row) {
        $postId = $row['post_id']; 
        $title = $row['title'];
        $post = $row['post'];
        $date = $row['post_date'];
        $authorName = PostQueries::getUserName($row['user_id']);
        $category = PostQueries::getCategory($row['category_id']);
        $_SESSION['currentPostId'] = $postId;

        $comments = PostQueries::getCommentCount($postId);

        // generate HTML for each post
        $postsHTML .= "
        <div class='formdiv'>
            <h1>Post</h1>
            <form action='../../comment system/php/commentpage.php' method='get'>
                <label class='option' for=''>Name<input class='name' type='text' value='$authorName' readonly></label><br>
                <label class='option' for=''>Title<input class='title' type='text'  value='$title' readonly></label><br>
                <label class='option' for=''>Category<input class='category' value='$category' name='category' type='text' ></label><br>
                <label class='option' for=''>Date<input class='date' type='text'  value='$date' readonly></label><br>
                
                
                <input class='date' type='hidden' name='postId' value='$postId' readonly>

                <textarea type='text' name='post' readonly>$post</textarea>
                <p>comments:  $comments </p>
                <ul>
                
                    <li><button class='button2'>UpVote</button></li>
                    <li><button class='button2'>DownVote</button></li>
                    <button type='submit' class='button2' name='comment_post_id' value='$postId'>Comment</button>
                
                </ul>
                
            </form>
        </div>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/postComment.css">
    <title>postComment</title>

</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href="../../../Assignment 3/homePage/php/HomePage.php">Mingle!</a></div>
            <ul>
                <li><a href="#" target="_blank" ><?php echo $userName ?></a></li>
            </ul>
        </div>
    </nav>
    
    <?php echo $postsHTML; ?> <!-- Display the generated HTML for posts -->

</body>
</html>
