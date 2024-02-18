<?php

require_once '../../DataBaseConnection/DataBaseConnection.php';

class PostQueries{

    public static function search($name, $title, $category, $date){

        $conn = new DataBaseConnection();

        // check if the user entered the title to search with
        if(!(empty($title))){

            // if name or title or category are empty then search with only the title
            if(empty($name) || empty($title) || empty($category)){
                $title = mysqli_real_escape_string($conn->getConnection(),$title);

                $query = mysqli_query($conn->getConnection(), "SELECT * FROM post WHERE 
                title='{$title}'");  //search with title

                if($query){
                    $result = $query->fetch_all(MYSQLI_ASSOC);
                    if(!empty($result)){

                        $_SESSION['search_result'] = $result;
                        return $result; // found posts
                        
                    }
                    else{
                        throw new Exception('The post you are searching for does not exist!'); // did not find posts
                    }
                }
            }else{
                // escape against SQLi
                $title = mysqli_real_escape_string($conn->getConnection(),$title);

                try{
                $userId = PostQueries::getUserId($name);
                }catch(Exception $e){
                    echo $e->getMessage();
                    exit;
                }
                // search using name, category, date and title
                $query = mysqli_query($conn->getConnection(), "SELECT * FROM post WHERE 
                user_id='{$userId}' AND category_id='{$category}' AND title='{$title}' AND post_date='{$date}' ");

                if($query){
                    $result = $query->fetch_all(MYSQLI_ASSOC);
                    if(!empty($result)){
                        $_SESSION['search_result'] = $result;
                        return $result; // found posts
                        
                    }
                    else{
                        throw new Exception('The post you are searching for does not exist!'); // did not find posts
                    }
                }

            }

        }
    }
    // function returns username to display it with the post
    public static function getUserName($userId){
        $conn = new DataBaseConnection();

        $query = mysqli_query($conn->getConnection(), "SELECT user_name FROM user WHERE 
        user_id='{$userId}'");

        $result = mysqli_fetch_assoc($query);

        return $result['user_name'];

    }
    // function returns category to display it with the post
    public static function getCategory($categoryId){
        $conn = new DataBaseConnection();

        $query = mysqli_query($conn->getConnection(), "SELECT category FROM category WHERE 
        category_id='{$categoryId}'");

        $result = mysqli_fetch_assoc($query);

        return $result['category'];

    }
    // function returns user id to search for the post
    public static function getUserId($name){
        $conn = new DataBaseConnection();

        $query = mysqli_query($conn->getConnection(), "SELECT user_id FROM user WHERE 
        user_name='{$name}'");

        $result = mysqli_fetch_assoc($query);

        if($result){
            return $result['user_id'];
        }else{
            throw new Exception("the user doesnt exist!");
        }

    }
    // function to get comment count and display it on the post
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