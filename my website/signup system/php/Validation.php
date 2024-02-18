<?php

class Validation{

    //static function to validate the inputs data in the sign up form
    public static function validateData($fname, $lname,$userName, $address, $phone, $birth, $usertype, $email, $fpassword, $spassword, $gender) : bool{

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                
            }
            if(($fpassword!=($spassword))){
                throw new Exception("the password and it's confirmation doesn't match!");
            }
            $length = strlen($fpassword);
            if($length < 8 || $length > 16){
                throw new Exception("The password should be in the range of 8 to 16 !");
            }
            if((2024 - (int)$birth) < 18 ){
                throw new Exception("This website for 18 or Older!");
            }

            $fname = filter_var($fname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if(empty($fname)){
                throw new Exception("invalid first name!");
            }

            $lname = filter_var($lname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if(empty($lname)){
                throw new Exception("invalid last name!");
            }

            if(empty($userName)){
                throw new Exception("Enter user name!");
            }
            if(empty($email)){
                throw new Exception("The email field is empty!");
            }
            if(empty($fpassword) || empty($spassword)){
                throw new Exception("You should enter the password and it's confirmation!");
            }
            if(empty($birth)){
                throw new Exception("You should enter the date of birth!");
            }
            if(empty($usertype)){
                throw new Exception("You should pick A user Type");
            }
            if(empty($phone)){
                throw new Exception("You should enter the phone number!");
            }
            if(empty($gender)){
                throw new Exception("You should enter the Gender!");
            }
            if(empty($address)){
                throw new Exception("You should enter the Address!");
            }
            
            if (!preg_match("/^[a-zA-Z0-9_]+$/", $userName)) {
                    // Invalid username format
                    throw new Exception("Invalid username format");
                }

            if(!(ctype_alpha($fname) && ctype_alpha($lname))){
                throw new Exception("The Name Can't contain any numbers or A special character!");
            }
            if(!is_numeric($phone)){
                throw new Exception("The Phone Number should Be all Digits!");
            }
        return true;  
    }
}