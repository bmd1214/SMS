<?php

require_once 'postsQueries.php';

class PostManager {

    private $postsHTML = '';
    private $userName;

    public function __construct() {
        session_start();

        $this->userName = $_SESSION['userName'];
        $this->generatePostsHTML();
        $this->handleVotes();
    }

    private function generatePostsHTML() {
        try {
            posts::getPosts();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        if (isset($_SESSION['search_result'])) {
            $searchResult = $_SESSION['search_result'];

            usort($searchResult, function ($a, $b) {
                $upVotesA = Posts::getUpVoteCount($a['post_id']);
                $upVotesB = Posts::getUpVoteCount($b['post_id']);
                return $upVotesB - $upVotesA;
            });

            foreach ($searchResult as $row) {
                $postId = $row['post_id'];
                $title = $row['title'];
                $post = $row['post'];
                $date = $row['post_date'];
                $authorName = Posts::getAuthorName($row['user_id']);
                $category = Posts::getCategory($row['category_id']);

                $upVote = Posts::getUpVoteCount($postId);
                $downVote = Posts::getDownVoteCount($postId);
                $comments = Posts::getCommentCount($postId);

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
                        <button type='submit' class='button2'>Comment</button>
                    
                    </ul>
                    
                    </form>
                </div>
                ";
            }
        }
    }

    private function handleVotes() {
        if (isset($_GET['upvote']) || isset($_GET['downvote'])) {
            $clickedPostId = $_GET['postId'];

            if (isset($_GET['upvote'])) {
                $vote = $_GET['upvote'];
                Posts::addVote($_SESSION['user_id'], $clickedPostId, $vote);
            } elseif (isset($_GET['downvote'])) {
                $vote = $_GET['downvote'];
                Posts::addVote($_SESSION['user_id'], $clickedPostId, $vote);
            } else {
                echo "Can Not Add Vote At The Moment";
            }

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
    public function getUserName(){
        return $this->userName;
    }
    public function getPostsHTML() {
        return $this->postsHTML;
    }
}

?>
