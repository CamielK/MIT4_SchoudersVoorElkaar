<?php

class article {
    
    //find article that matches the given article ID
    public function getArticle($artId) {
        
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection();
        $articleInfo = $db->getArticle($artId);
        
        if (!$articleInfo) {
            $articleInfo['error'] = 'Error getting article from database.';
        }
        
        
        //return article json
        return json_encode($articleInfo);
    }
    
    
    //return a list of articles that match the given searchstring
    public function findArticles($searchstring) {
        
        
    }
    
}

?>
