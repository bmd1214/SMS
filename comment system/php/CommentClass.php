<?php

namespace MyNamespace;

use DataBaseConnection;
use Exception;

require_once '../../DataBaseConnection/DataBaseConnection.php';

class Comment{
    private $comment;

    public function __construct($comment, $userName, $postId){

        $this->comment = $comment;

        $this->insertComment($userName, $postId);
    }
    public function display(){
        print "comment: " . $this->comment . '<br>';
    }

    public function insertComment($userName, $postId){
        $conn = new DataBaseConnection();
        $userId = Comment::getUserId($userName);
        $date = date("Y-m-d");

        $query = mysqli_query($conn->getConnection(),"INSERT INTO comment(user_id,post_id, comment,date)
        VALUES ('$userId', '$postId', '$this->comment', '$date')");

        if(!$query){
            throw new Exception('Something Wrong happend');
        }

    }

    public static function getUserId($userName){
        $conn = new DataBaseConnection();

        $query = mysqli_query($conn->getConnection(), "SELECT user_id FROM user WHERE 
        user_name='{$userName}'");

        $result = mysqli_fetch_assoc($query);

        if($result){
            return $result['user_id'];
        }

    }
    
}

?>