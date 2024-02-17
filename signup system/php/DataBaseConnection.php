<?php


class DataBaseConnection{
    private $host = "localhost";
    private $userName = "root";
    private $password = "";
    private $dbName = "sms_db";
    private $connection;

    //when an object is created the construct will call function to make connection with DB.
    public function __construct(){
        $this->connect();
        
    }
    public function __destruct(){
        $this->closeConnection();

    }
    public function getConnection(){
        if(isset($this->connection)){
            return $this->connection;
        }
    
    }

    // make connection with db
    private function connect(){
        $this->connection = new mysqli($this->host, $this->userName, $this->password, $this->dbName);

        if($this->connection->connect_error){
            die("Connevtion Failed: " . $this->connection->connect_error);
        }

    }
    private function closeConnection(){
        if($this->connection){
            $this->connection->close();
        }
    }

}

?>