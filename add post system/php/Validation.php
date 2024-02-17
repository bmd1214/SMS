<?php

// the validation for the post inputs
class Validation{

    public static function validateData($title,$category,$post){


        if(empty($title)){
            throw new Exception("the title is empty");

        }

        if(empty($category)){
             throw new Exception("You sould choose a Category");
        }

        
        if(empty($post)){
            throw new Exception("You Can't post An empty post!");
        }

    }
}

?>