<?php

require_once 'postsQueries.php';

class PostManager {
    //instantiate an empty string to store the posts
    private $postsHTML = '';
    private $userName;

    public function __construct() {
        session_start();

        $this->userName = $_SESSION['userName'];
        $this->generatePostsHTML();
        $this->handleVotes();
    }
    // function gets the posts, sort them then store then in an instance 
    private function generatePostsHTML() {
        try {
            postsQueries::getPosts();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        // get the post in the session array
        if (isset($_SESSION['search_result'])) {
            $searchResult = $_SESSION['search_result'];
            // sort function used to sort the posts based on the up-votes count
            usort($searchResult, function ($a, $b) {
                $upVotesA = PostsQueries::getUpVoteCount($a['post_id']);
                $upVotesB = PostsQueries::getUpVoteCount($b['post_id']);
                return $upVotesB - $upVotesA;
            });

            // add the appropraite values in every post
            foreach ($searchResult as $row) {
                $postId = $row['post_id'];
                $title = $row['title'];
                $post = $row['post'];
                $date = $row['post_date'];
                $authorName = PostsQueries::getAuthorName($row['user_id']);
                $category = PostsQueries::getCategory($row['category_id']);

                $upVote = PostsQueries::getUpVoteCount($postId);
                $downVote = PostsQueries::getDownVoteCount($postId);
                $comments = PostsQueries::getCommentCount($postId);

                $this->postsHTML .= "
                <div class='formdiv'>
                    <h1>Post</h1>
                    <form action='' method='get'>
                    <label class='option' for=''>Name<input class='name' type='text' value='$authorName' readonly></label><br>
                    <label class='option' for=''>Title<input class='title' type='text'  value='$title' readonly></label><br>
                    <label class='option' for=''>Category<input class='category' value='$category' name='category' type='text' ></label><br>
                    <label class='option' for=''>Date<input class='date' type='text'  value='$date' readonly></label><br>
                    
                    <input class='date' type='hidden' name='postId' value='$postId' readonly>
    
                    <textarea type='text' name='post' readonly>$post</textarea> <br>
                    <span>&nbsp&nbsp&nbsp&nbsp&nbsp Up Vote:  $upVote &nbsp&nbsp&nbsp  Down Vote:  $downVote &nbsp&nbsp comments: $comments </span>
    
                    <ul>
      
                        <li> <button class='button2' name='upvote' value='1'>UpVote</button></li>
                        <li> <button class='button2' name='downvote' value='2' >DownVote</button></li>
                        <a href='../../comment system/php/commentpage.php' ><button class='button2'>Comment</button></a>
                    
                    </ul>
                    
                    </form>
                </div>
                ";
            }
        }
    }
    // function handle the process of voting if the buttons been pressed
    private function handleVotes() {
        if (isset($_GET['upvote']) || isset($_GET['downvote'])) {
            $clickedPostId = $_GET['postId'];

            try{
                // if up-vote button is pressed
                if (isset($_GET['upvote'])) {
                    $vote = $_GET['upvote'];
                    PostsQueries::addVote($_SESSION['user_id'], $clickedPostId, $vote);
                // if down-vote button is pressed
                } elseif (isset($_GET['downvote'])) {
                    $vote = $_GET['downvote'];
                    PostsQueries::addVote($_SESSION['user_id'], $clickedPostId, $vote);
                } else {
                    echo "Can Not Add Vote At The Moment";
                }
                // stay in the page after voting
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();

            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
    // returns the user name
    public function getUserName(){
        return $this->userName;
    }
    // returns the posts after sorting them based on the up-vote count
    public function getPostsHTML() {
        return $this->postsHTML;
    }
}

?>
