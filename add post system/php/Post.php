<?php

require_once '../../signup system/php/DataBaseConnection.php';
require_once 'Validation.php';

class Post{
    private $title;
    private $category;
    private $post;

    public function __construct($title,$category, $post){

        $this->title = $title;
        $this->category = $category;
        $this->post = $post;

       // validate the data after creating an object
        try{
            // static function in class validation
            Validation::validateData($this->title, $this->category, $this->post); 
        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }
    public function display(){
        print "title: " . $this->title . '<br>';
        print "Category: " . $this->category . '<br>';
        print "The Post: " . $this->post;

    }

    // function to insert the post into the databse
    public function insertPost($userId){
        $conn = new DataBaseConnection();

        $date = date("Y-m-d");

        $query = mysqli_query($conn->getConnection(), "INSERT INTO post(user_id, title, category_id, post, post_date)
        VALUES ('$userId','$this->title','$this->category','$this->post','$date')");
      
    }

    // update the post values
    public function updatepost($postId){

        $conn = new DataBaseConnection();

        $date = date("Y-m-d");

        $query = mysqli_query(
            $conn->getConnection(),
            "UPDATE post 
            SET category_id = '$this->category', post = '$this->post', title = '$this->title', post_date= '$date' 
            WHERE post_id='$postId'");

    }
    public static function getPosts($userId){

        $conn = new DataBaseConnection(); // database connection

        $query = mysqli_query($conn->getConnection(), "SELECT * FROM post WHERE user_id = '$userId'" );
    
        if ($query) {
            $result = $query->fetch_all(MYSQLI_ASSOC);
            
            if(!empty($result)){
                $_SESSION['posts'] = $result;
                return $result;

            }else{
                throw new Exception('You do not have any posts!'); // did not find posts
                }

        }


    }
    public static function getCategory($categoryId){
        $conn = new DataBaseConnection();

        $query = mysqli_query($conn->getConnection(), "SELECT category FROM category WHERE 
        category_id='{$categoryId}'");

        $result = mysqli_fetch_assoc($query);

        return $result['category'];

    }

        // Static function to delete a post by post ID
        public static function deletePost($postId) {
            try {
                // Establish database connection (you may need to modify this based on your implementation)
                $conn = new DataBaseConnection();
        
                // Start a transaction
                mysqli_begin_transaction($conn->getConnection());
        
                try {
                    // Delete comments associated with the post
                    $commentQuery = mysqli_query($conn->getConnection(), "DELETE FROM comment WHERE post_id='{$postId}'");
        
                    // Check if comments were successfully deleted
                    if (!$commentQuery) {
                        throw new Exception("Error deleting comments.");
                    }
        
                    // Now, delete the post
                    $postQuery = mysqli_query($conn->getConnection(), "DELETE FROM post WHERE post_id='{$postId}'");
        
                    // Check if the post was successfully deleted
                    if (!$postQuery) {
                        throw new Exception("Error deleting post.");
                    }
        
                    // Commit the transaction if all queries are successful
                    mysqli_commit($conn->getConnection());
                } catch (Exception $e) {
                    // Rollback the transaction if any error occurs
                    mysqli_rollback($conn->getConnection());
                    throw $e; // Re-throw the exception for further handling
                }
            } catch (Exception $e) {
                throw new Exception("Error deleting post: " . $e->getMessage());
            }
        }
        
}


?>