<?php
require_once '../../signup system/php/DataBaseConnection.php';
require_once 'Post.php';

session_start();

if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    echo "There is something wrong with the user ID.";
    exit;
}

try {
    // get existing posts data
    $posts = Post::getPosts($userId);

    // check if there are existing posts
    if (!empty($posts)) {
        // this used to store HTML for posts
        $postsHTML = '';

        // iterate over the posts array
        foreach ($posts as $post) {
            $categoryId = $post['category_id'];
            $postId = $post['post_id'];
            $title = $post['title'];
            $category = Post::getCategory($categoryId);
            $date = $post['post_date'];
            $postText = $post['post'];

            // generate HTML for each post
            $postsHTML .= "
            <div class='formdiv'>
                <h1>Post</h1>
                <form action='' method='post'>
                    <label class='option' for='title'>Title<input class='input1' type='text' name='title' value='$title'></label><br>
                    <label class='option' for='date'>Date<input class='input1' type='text' readonly value='$date'></label><br>
                    <label class='option' for='category'>Category
                        <select name='category'>
                            <option value='$category'>$category</option>
                            <option value='1'>Politics</option>
                            <option value='2'>Nowadays</option>
                            <option value='3'>Education</option>
                            <option value='4'>Science</option>
                        </select>
                    </label>
                    <textarea name='post'>$postText</textarea>
                    <input type='hidden' name='postId' value='$postId' readonly>
                    <label class='option' for='imageupload'>Upload Media</label>
                    <input type='file' name='imageupload' class='file-input'>
                    <ul>
                    <button class='button2' type='submit' name='action' value='submit'>Save</button>
                    <button class='button2' type='submit' name='action' value='delete'>Delete</button>
                        
                    </ul>
                </form>
            </div>
            ";
        }
    } else{
        // If there are no existing posts, add message to postsHTML
        $postsHTML = '<p>No posts found.</p>';
    }
} catch(Exception $e){
    echo $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    
        if ($action == 'delete') {
            //code for deleting the post 
        } elseif ($action == 'submit') {
            // code for submitting the form 
        }
    if ($_POST['action'] == 'delete') {
        // if the delete button is pressed, call the static deletePost function
        $postIdToDelete = $_POST['postId'];
        Post::deletePost($postIdToDelete);

        // redirect to the home page after deletion
        header("Location: ../../homePage/php/HomePage.php");
        exit;
    }
}

    // handle form submission for editing posts
    $editedPostId = $_POST['postId'];
    $editedTitle = $_POST['title'];
    $editedCategory = $_POST['category'];
    $editedPost = $_POST['post'];

    // to check if the user did not change category assign the old one
    if(empty($editedCategory)){$editedCategory = $categoryId;}

    // Create an object with the updated values
    $editedPost = new Post($editedTitle, $editedCategory, $editedPost);

    // Update the post with the postId
    $editedPost->updatePost($editedPostId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/postPage.css">
    <title>Edit Posts</title>

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

    <?php echo $postsHTML; ?>

</body>
</html>
