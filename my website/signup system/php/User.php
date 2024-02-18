<?php

require_once 'DataBaseConnection.php';
require_once 'Validation.php';

class User{
    private $fname;
    private $lname;
    private $userName;
    private $address;
    private $phone;
    private $birth;
    private $usertype;
    private $email;
    private $fpassword;
    private $spassword;
    private $gender;

    public function __construct($fname, $lname,$userName, $address, $phone, $birth, $usertype, $email, $fpassword, $spassword, $gender){
        $this->fname = $fname;
        $this->lname = $lname;
        $this->userName = $userName;
        $this->address = $address;
        $this->phone = $phone;
        $this->birth = $birth;
        $this->usertype = $usertype;
        $this->email = $email;
        $this->fpassword = $fpassword;
        $this->spassword = $spassword;
        $this->gender = $gender; 
        
        // using static function in class Validation to validate data
        try{
            Validation::validateData($this->fname, $this->lname,$this->userName, $this->address, $this->phone, $this->birth, $this->usertype, $this->email, $this->fpassword, $this->spassword, $this->gender);
        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
        
    }
    public function display(){
        print "Name: " . $this->fname . " " . $this->lname . '<br>';
        print "Address: " . $this->address . '<br>';
        print "Phone Number: " . $this->phone . '<br>';
        print "Date Of Birth: " . $this->birth . '<br>';
        print "The User Type: " . $this->usertype . '<br>';
        print "E-Mail: " . $this->email . '<br>';
        print "Password: " . $this->fpassword . '<br>';
        print "Gender: " . $this->gender . '<br>';
    }
    
    // insert new user into data base after signing up
    public function insertUser(){
        $conn = new DataBaseConnection();
        
        $stat = $conn->getConnection()->prepare("insert into user(gender_id, user_type_id, first_name, last_name,
            user_name, address, phone_number, date_of_birth, email, password)
            values (?,?,?,?,?,?,?,?,?,?) ");
        $stat->bind_param('ssssssssss',$this->gender, $this->usertype,$this->fname, $this->lname, 
        $this->userName, $this->address, $this->phone, $this->birth, $this->email, $this->fpassword);

        $stat->execute();
    }
    
    public function updateUser($userId){

        $conn = new DataBaseConnection();

        // update user's data using the id "primary key"
        $query = mysqli_query(
            $conn->getConnection(),
            "UPDATE user 
            SET first_name = '$this->fname', last_name = '$this->lname', email = '$this->email', user_name = '$this->userName', address = '$this->address',
            phone_number = '$this->phone', date_of_birth = '$this->birth', user_type_id = '$this->usertype', password = '$this->spassword', gender_id = '$this->gender'
            WHERE user_id = $userId");

    }
}

?>