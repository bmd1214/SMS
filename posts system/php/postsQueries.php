<?php

require_once '../../DataBaseConnection/DataBaseConnection.php';

class PostsQueries{
    // function to return the posts in the dataBase
    public static function getPosts(){
        $conn = new DataBaseConnection;

        $query = mysqli_query($conn->getConnection()," SELECT * FROM post ");

        if($query){
            $result = $query->fetch_all(MYSQLI_ASSOC);
            $_SESSION['search_result'] = $result;
           // return $result;
        }else{
            // throw an Exception If there is a problem getting the posts
            throw new Exception("There is No Posts To Show In The Moment");
        }
    }
    // function to get the name of the creater of the post
    public static function getAuthorName($authorId){

        $conn = new DataBaseConnection;
        $query = mysqli_query($conn->getConnection(), "SELECT user_name FROM user WHERE user_id = '{$authorId}'");

        $result = mysqli_fetch_assoc($query);

        return $result['user_name'];

    }
    // function to get the category and show it with the post
    public static function getCategory($categoryId){
        $conn = new DataBaseConnection;
        $query = mysqli_query($conn->getConnection(), "SELECT category FROM category WHERE category_id = '{$categoryId}'");

        $result = mysqli_fetch_assoc($query);

        return $result['category'];
    }
    // function to add a vote on the post
    public static function addVote($userId, $postId, $vote){
        $conn = new DataBaseConnection;
        try{
            // starting a transaction to make sure the check function succeds first
           $conn->getConnection()->begin_transaction();

            // call a function to check if the post is already been voted by the same user
            if(PostsQueries::checkVote($userId, $postId, $vote)){
                $query = mysqli_query($conn->getConnection(), "INSERT INTO post_vote (user_id, post_id, vote_id) 
                VALUES ('{$userId}','{$postId}','{$vote}') ");

                $conn->getConnection()->commit();
            }
        }catch(Exception $e){
            // if exceptiom is been thrown, rollBack
            $conn->getConnection()->rollback();
            throw $e; // re-throw the Exception 
        }

    }
    public static function checkVote($userId, $postId, $vote){
        $conn = new DataBaseConnection;
        $query = mysqli_query($conn->getConnection(), "SELECT * FROM post_vote WHERE user_id='{$userId}' AND post_id='{$postId}'");

        if($query){
            $result = mysqli_fetch_assoc($query);
            if(!empty($result)){
                // if the user voted up or down and pressed the same button, then delete the vote from the post
                if($result['vote_id'] == $vote){
                    $query = mysqli_query($conn->getConnection(), "DELETE FROM post_vote WHERE user_id='{$userId}' AND post_id='{$postId}'");
                
                //if the user pressed a different type of vote, then change his vote
                }else{
                    $query = mysqli_query($conn->getConnection(), "UPDATE post_vote SET vote_id='{$vote}' WHERE user_id='{$userId}' AND post_id='{$postId}'");
                }
            // if the user has not voted before, procced the add vote function
            }else{
                return true;
            }

        }else{
            // throw exception to stop the transaction
            throw new Exception("Something Wrong With The DB Connection!");
        }

    }
    // function returns the up-vote count
    public static function getUpVoteCount($postId){

        $conn = new DataBaseConnection;

        $query = mysqli_query($conn->getConnection(), "SELECT COUNT(*) as up_vote_count FROM post_vote 
        WHERE post_id = '{$postId}' AND vote_id='1'");

        $result = mysqli_fetch_assoc($query);
        if(! empty($result)){
            return $result['up_vote_count'];
        }else{
            return 0;
        }
    }
    // function returns the down-vote count
    public static function getDownVoteCount($postId){

        $conn = new DataBaseConnection;

        $query = mysqli_query($conn->getConnection(), "SELECT COUNT(*) as down_vote_count FROM post_vote 
        WHERE post_id = '{$postId}' AND vote_id='2'");

        $result = mysqli_fetch_assoc($query);
        if(! empty($result)){
            return $result['down_vote_count'];
        }else{
            return 0;
        }
    }
    // function returns the comments count to show it
    public static function getCommentCount($postId){
        
        $conn = new DataBaseConnection();
        $query = mysqli_query($conn->getConnection(), "SELECT COUNT(*) as comments_count FROM comment WHERE post_id = '{$postId}'");
    
        $result = mysqli_fetch_assoc($query);
       
        if ($result && isset($result['comments_count'])){
            return $result['comments_count'];
        }
        return 0;
    }

}

?>