<?php

class rating {
    
    //find article that matches the given article ID
    public function getRating($userId, $articleId) {
        
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection();
        
        //form query
        $query = "
            SELECT Rating.rating
            FROM Rating
            WHERE Rating.article_id='$articleId'
            AND Rating.user_id='$userId';";
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        if ($result->num_rows > 0) {
            $response = $result->fetch_assoc();
        } else {
            $response = array ('rating' => 0);
        }
        
        //close connection
        $db->closeConnection();
    
        //return article json
        return json_encode($response);
        
    }
    
    
    //add rating to database
    public function addRating($userId, $articleId, $stars) {
    	
      //call to database connection
      include_once('dbConnection.php');
      $db = new databaseConnection();
      
      //delete previous user_id/article_id ratings (if any)
      $query = "
      	DELETE
				FROM Rating
				WHERE Rating.user_id = $userId
				AND Rating.article_id = $articleId
				";
      $result = $db->queryDatabase($query);
      
      //add new rating
      $query = "INSERT INTO `sve`.`Rating` (`id`, `user_id`, `article_id`, `rating`) VALUES (NULL, '".$userId."', '".$articleId."', '".$stars."');";
      $result = $db->queryDatabase($query);
      
      //recalculate article rating
      $response['updating_article_status'] = $this->recalculateArticleRating($articleId);

      //check result
      if ($result) {
      	$response['adding_rating_status'] = 'Rating was added.';
      } else {
          $response['adding_rating_status'] = 'Error adding rating.';
      }
      
      //close connection
      $db->closeConnection();
  
      //return result
      return json_encode($response);
    }
    
    
    
    //recalculate the new article rating and update the article
    private function recalculateArticleRating($articleId) {
    	
    	//call to database connection
      include_once('dbConnection.php');
      $db = new databaseConnection();
      
      //delete previous user_id/article_id ratings (if any)
      $query = "
      	SELECT COUNT(*) as total_ratings, AVG(Rating.rating) as average_rating
      	FROM Rating
      	WHERE Rating.article_id = $articleId
      	";
      $result = $db->queryDatabase($query);

      //check result
      if ($result->num_rows > 0) {
      	$row = $result->fetch_assoc();
      	
      	include_once('article.php');
      	$article = new article();
      	
      	$articleJson = array(
      	    'total_ratings' => $row['total_ratings'],
      	    'average_rating' => $row['average_rating'],
      	    'article_id' => $articleId
      	    );
      	
      	$response = $article->editArticle($articleJson);
      	
      } else {
        $response = 'Error updating article rating.';
      }
      
      //close connection
      $db->closeConnection();
  
      //return result
      return $response;
    	
    }
    
    
}

?>
