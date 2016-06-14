<?php

class comment {
    
    
    //return list of comments for the given article
    public function getCommentsByArticleId($artId) {
        
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection();
        
        //form query
        $query = "
            SELECT Comment.*, User.name AS author_name
            FROM `Comment`
            JOIN User ON Comment.user_id = User.id
            WHERE Comment.article_id='$artId';";
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        if ($result->num_rows > 0) {
            $commentList = array();
        	while ($row = $result->fetch_assoc()) {
        		$commentList['comments'][] = $row;
        	}
        } else {
            $commentList['error'] = 'Did not find any comments for the given article.';
        }
    
        //return article json
        return json_encode($commentList);
        
    }
    
    
    
    //return list of comments for the given user
    public function getCommentsByUserId($userId) {
        
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection();
        
        //form query
        $query = "
            SELECT Comment.*, Article.title AS article_title
            FROM `Comment`
            JOIN Article ON Comment.article_id = Article.id
            WHERE Comment.user_id='$userId';";
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        if ($result->num_rows > 0) {
            $commentList = array();
        	while ($row = $result->fetch_assoc()) {
        		$commentList['comments'][] = $row;
        	}
        } else {
            $commentList['error'] = 'Did not find any comments for the given user.';
        }
    
        //return article json
        return json_encode($commentList);
        
    }
    
    
    //add the given comment to the database
    public function addComment($commentJson) {
    	
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection();
        
        //form query
        $query = "
            INSERT INTO `sve`.`Comment` (`id`, `article_id`, `user_id`, `comment_text`, `created_at`, `updated_at`) 
            VALUES (NULL, '".$commentJson['article_id']."', '".$commentJson['user_id']."', '".$commentJson['comment_text']."', '".$commentJson['created_at']."', '".$commentJson['created_at']."');";
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        if ($result->num_rows > 0) {
        	$response['success'] = 'Comment was added.';
        } else {
            $response['error'] = 'Error adding comment.';
        }
        
        //close connection
        $db->closeConnection();
    
        //return result
        return json_encode($response);
    }
        
}

?>