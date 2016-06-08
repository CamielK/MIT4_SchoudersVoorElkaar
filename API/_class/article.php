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
    
        //close connection
        $db->closeConnection();
    
        //return article json
        return json_encode($articleInfo);
        
    }
    
    
    //return a list of articles that match the given searchstring
    public function addArticle($articleJson) {
    	
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection();
        
        //form query
        $query = "
            INSERT INTO `sve`.`Article` (`id`, `author_id`, `title`, `content`, `tags`, `category`, `average_rating`, `total_ratings`, `created_at`, `published_at`, `updated_at`) 
            VALUES (NULL, '".$articleJson['author_id']."', '".$articleJson['title']."', '".$articleJson['content']."', '".$articleJson['tags']."', '".$articleJson['category']."', '0', '0', '".$articleJson['created_at']."', '".$articleJson['published_at']."', '".$articleJson['updated_at']."');";
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        if ($result->num_rows > 0) {
        	$response['success'] = 'Article was added.';
        } else {
            $response['error'] = 'Error adding article.';
        }
        
        //close connection
        $db->closeConnection();
    
        //return result
        return json_encode($response);
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
        
        //close connection
        $db->closeConnection();
    
        //return article json
        return json_encode($articleList);
    }
    
}

?>
