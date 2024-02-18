<?php

require_once 'Validation.php';
require_once '../../signup system/php/DataBaseConnection.php';

class User{

    private $userName;
    private $password;
    private $user;

    public function __construct($userName, $password) {
        $this->userName = $userName;
        $this->password = $password;

        $this->checkUser(); // validtion in constructor

    }
    public function display() {
        print "user name: " . $this->userName . '<br>';
        print "Password: " . $this->password;
    }
    public function checkUser(){
        $this->user = new Validation($this->userName, $this->password);
        try{
            $this->user->validateData(); // validation function

        }catch(Exception $e){
           echo $e->getMessage();
        }
        
    }

    // check if the user signed up before or not
    public function userExist(){

        $conn = new DataBaseConnection();
        
        // escaping user name before using it in the query
        $userName = mysqli_real_escape_string($conn->getConnection(), $this->userName);

        $query = mysqli_query($conn->getConnection(), "SELECT * FROM user WHERE 
        user_name='{$userName}' AND password='{$this->password}'");

        if($query){
            
            $result = mysqli_fetch_assoc($query);

            if(!empty($result)){

                return $result['user_name']; // user exists
            }
            else{
                return false; //user does not exist
            }
        }

    }
        
}

?>