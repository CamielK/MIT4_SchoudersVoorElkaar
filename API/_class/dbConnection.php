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
    
    //close connection
    private function closeConnection() {
        $this->connection->close();
    }
    
    //do query
    private function queryDatabase($query) {
        return $this->connection->query($query);
    }
    
    
    //find article that matches the given article ID
    public function getArticle($artId) {
        
        //return false if there is no connection
        if (!($this->connection)) {
            return false;
        }
        
        //form query
        $query = "SELECT * FROM `Article` WHERE ID='$artId';";
        
        //do query
        $result = $this->queryDatabase($query);
    
        
        //close connection
        $this->closeConnection();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
        
    }
    
    
    //return a list of all articles matching the search string
    public function findArticles($searchstring) {
    	
    	//return false if there is no connection
        if (!($this->connection)) {
            return false;
        }
        
        //parse search string to block sql injections
        $escaped_searchstring = mysql_real_escape_string($searchstring);
        
        //form query
        $query = "SELECT * FROM `Article` WHERE (Title LIKE '%$escaped_searchstring%') OR (Content LIKE '%$escaped_searchstring%') OR (Tags LIKE '%$escaped_searchstring%')";
        
        //do query
        $result = $this->queryDatabase($query);
    
        
        //close connection
        $this->closeConnection();
        
        if ($result->num_rows > 0) {
        	$articleList = array();
        	while ($row = $result->fetch_assoc()) {
        		$compressedRow = array();
        		$compressedRow[] = $row['ID'];
        		$compressedRow[] = $row['Title'];
        		$compressedRow[] = $row['Tags'];
        		$compressedRow[] = $row['PublishDate'];
        		$compressedRow[] = $row['AuthorID'];
        		$articleList[] = $compressedRow;
        	}
        	return $articleList;
        } else {
            return false;
        }
    		
    }
    
    
}







?>