<?php


class databaseConnection {
    
    
    //private vars
    private $connection;
    
    
    //constructor
    public function __construct() {
        $this->connection = $this->makeConnection();
    }
    
    
    //makes connection with database
    private function makeConnection() {
        $conn = new mysqli("localhost","sve","svezuyd","sve");
        return $conn;
    }
    
    //return connection
    public function getConnection() {
        return $this->connection;
    }
    
    //close connection
    public function closeConnection() {
        $this->connection->close();
    }
    
    //do query
    public function queryDatabase($query) {
        
        //return false if there is no connection
        if (!($this->connection)) {
            return false;
        }
        
        //query database
        $queryResult = $this->connection->query($query);
        
        //return query output
        return $queryResult;
    }
    
    
}


?>