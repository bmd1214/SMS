<?php

namespace MyNamespace;

use DataBaseConnection;
use Exception;
use Validation;

require_once 'Validation.php';
require_once '../../DataBaseConnection/DataBaseConnection.php';

class Comment{
    private $comment;

    public function __construct($comment, $userName, $postId){

        $this->comment = $comment;

        // check comment before procced
        try{
            Validation::validateComment($comment);
        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }

        $this->insertComment($userName, $postId); // insert the comment from the constructor
    }
    public function display(){
        print "comment: " . $this->comment . '<br>';
    }
    // function to insert the comment
    public function insertComment($userName, $postId){
        $conn = new DataBaseConnection();
        $userId = Comment::getUserId($userName);
        $date = date("Y-m-d");

        $query = mysqli_query($conn->getConnection(),"INSERT INTO comment(user_id,post_id, comment,date)
        VALUES ('$userId', '$postId', '$this->comment', '$date')");

        if(!$query){
            throw new Exception("could not post the comment!");
        }

    }
    // function returns the user id to associate it with comment
    public static function getUserId($userName){
        $conn = new DataBaseConnection();

        $query = mysqli_query($conn->getConnection(), "SELECT user_id FROM user WHERE 
        user_name='{$userName}'");

        $result = mysqli_fetch_assoc($query);

        // check if the result not empty
        if($result){
            return $result['user_id'];
        }
    }
    
}

?>