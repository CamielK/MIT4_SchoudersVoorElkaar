<?php

class article {
    
    //find article that matches the given article ID
    public function getArticle($artId) {
        
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection();
        
        //form query
        $query = "
            SELECT Article.*, User.name AS author_name
            FROM `Article` 
            JOIN User ON Article.author_id = User.id
            WHERE Article.id='$artId';";
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        $articleInfo = array();
        if ($result->num_rows > 0) {
            $articleInfo = $result->fetch_assoc();
        } else {
            $articleInfo['error'] = 'Error getting information from database.';
        }
    
        //return article json
        return json_encode($articleInfo);
        
    }
    
    
    //return a list of articles that match the given searchstring
    public function findArticles($searchstring) {
    	
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection();
        
        //form query
        $query = "
            SELECT Article.id, User.name AS author_name, Article.title, Article.tags, Article.category, Article.published_at, Article.updated_at
            FROM `Article` 
            JOIN User ON Article.author_id = User.id
            WHERE (Article.title LIKE '%$searchstring%') 
                OR (Article.content LIKE '%$searchstring%') 
                OR (Article.tags LIKE '%$searchstring%') 
                OR (Article.category LIKE '%$searchstring%')
                OR (User.name LIKE '%$searchstring%')";
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        $articleList = array();
        if ($result->num_rows > 0) {
        	while ($row = $result->fetch_assoc()) {
        		$articleList[] = $row;
        	}
        } else {
            $articleList['error'] = 'Did not find any resources matching the search string.';
        }
    
        //return article json
        return json_encode($articleList);
    }
    
}

?>
