<?php

    /* This php page serves as the main entry for backend API calls
        Requests should be targeted at URL: 
        'http://84.30.147.189/sveAPI/api/MAIN_ARG/SUB_ARGUMENTS'
        depending on the first argument, a few other arguments can be given
    */


    //*** add default json response headers
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');

    //*** filter request url arguments
    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    $input = json_decode(file_get_contents('php://input'),true);

    //*** execute API function depending on main argument
    $mainArg = array_shift($request);
    if ($mainArg==='getarticle') {
        //return the article information for the given article ID
        
        $articleId = array_shift($request);
        
        include_once('_class/article.php');
        $article = new article();
        
        echo $articleInfo = $article->getArticle($articleId);
        
        
    } else if ($mainArg==='SetArticle') {
        //edit or add the submitted argument information
        
        
    }  else if ($mainArg==='findarticle') {
        //return list of articles matching the search string
        
        $searchstring = array_shift($request);
        
        include_once('_class/article.php');
        $article = new article();
        
        echo $articleArr = $article->findArticles($searchstring);
        
    } else if ($mainArg==='test') {
        $arr = array('A' => 1, 'B' => 2, 'C' => 3, 'Response' => true);
        echo json_encode($arr);
    }
    else {
        $arr = array('Error' => 'Incorrect API arguments', 'Response' => false);
        echo json_encode($arr);
    }

?>