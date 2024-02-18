<?php

require 'CommentClass.php';

// validation for the comment
class Validation{

    public static function validateComment($comment){

            if(empty($comment)){
                throw new Exception("comment section can't be empty");
            }

    }
}

?>