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

}


?>