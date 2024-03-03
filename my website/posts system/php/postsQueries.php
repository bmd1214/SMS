<?php

require_once '../../DataBaseConnection/DataBaseConnection.php';

class Posts{

    public static function getPosts(){
        $conn = new DataBaseConnection;

        $query = mysqli_query($conn->getConnection()," SELECT * FROM post ");

        if($query){
            $result = $query->fetch_all(MYSQLI_ASSOC);
            $_SESSION['search_result'] = $result;
           // return $result;
        }else{
            throw new Exception("There is No Posts To Show In The Moment");
        }
    }
    public static function getAuthorName($authorId){

        $conn = new DataBaseConnection;
        $query = mysqli_query($conn->getConnection(), "SELECT user_name FROM user WHERE user_id = '{$authorId}'");

        $result = mysqli_fetch_assoc($query);

        return $result['user_name'];

    }
    public static function getCategory($categoryId){
        $conn = new DataBaseConnection;
        $query = mysqli_query($conn->getConnection(), "SELECT category FROM category WHERE category_id = '{$categoryId}'");

        $result = mysqli_fetch_assoc($query);

        return $result['category'];
    }
    public static function addVote($userId, $postId, $vote){
        $conn = new DataBaseConnection;

        if(Posts::checkVote($userId, $postId, $vote)){
            $query = mysqli_query($conn->getConnection(), "INSERT INTO post_vote (user_id, post_id, vote_id) 
            VALUES ('{$userId}','{$postId}','{$vote}') ");
        }

    }
    public static function checkVote($userId, $postId, $vote){
        $conn = new DataBaseConnection;
        $query = mysqli_query($conn->getConnection(), "SELECT * FROM post_vote WHERE user_id='{$userId}' AND post_id='{$postId}'");

        if($query){
            $result = mysqli_fetch_assoc($query);
            if(!empty($result)){
                if($result['vote_id'] == $vote){
                    $query = mysqli_query($conn->getConnection(), "DELETE FROM post_vote WHERE user_id='{$userId}' AND post_id='{$postId}'");
                }else{
                    $query = mysqli_query($conn->getConnection(), "UPDATE post_vote SET vote_id='{$vote}' WHERE user_id='{$userId}' AND post_id='{$postId}'");
                }

            }else{
                return true;
            }

        }

    }
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