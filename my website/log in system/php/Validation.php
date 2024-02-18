<?php


class Validation{
    private $userName;
    private $password;

    public function __construct($userName, $password){
        
        $this->userName = $userName;
        $this->password = $password;
    }

    public function validateData() : bool{

        // Validate the username and password
            if(empty($this->userName)){
                throw new Exception("The user name field is empty!");
            }
            if(empty($this->password)){
                throw new Exception("You should enter the password!");
            }

            $length = strlen($this->userName);
            if($length < 6 || $length > 40){
                throw new Exception("The name should be in the range of 6 to 16 !");
            }
            
            $length = strlen($this->password);
            if($length < 8 || $length > 16){
                throw new Exception("The password should be in the range of 8 to 16 !");
            }


        return true;

    }

}


?>