<?php

    /* This php page serves as the main entry for backend API calls
        Requests should be targeted at URL: 
        'http://84.30.147.189/sveAPI/api/MAIN_ARG/SUB_ARGUMENTS'
        depending on the first argument, a few other arguments can be given
    */


    //*** add default json response headers
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');

    //*** filter request url parameters
    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    $input = json_decode(file_get_contents('php://input'),true);


    //*** execute API function depending on main argument
    $mainArg = array_shift($request);
    if ($mainArg==='article') {
        
        //include article class
        include_once('_class/article.php');
        $article = new article();
        
        //check secondary argument
        $subArg = array_shift($request);
        if ($subArg==='get') { 
            //return given article id information
        
            $articleId = array_shift($request);
            echo $articleInfo = $article->getArticle($articleId);
            
        } else if ($subArg==='add') {
            //edit or add the submitted argument information
            
            if ($method==='POST') {
                echo $response = $article->addArticle($_POST);
            } else {
                $arr = array('Error' => 'Method should be post, but '.$method.' method received', 'Response' => false);
                echo json_encode($arr);
            }
            
            
        } else if ($subArg==='find') {
            //return a list of articles matching the search string
            
            $searchstring = array_shift($request);
            echo $articleArr = $article->findArticles($searchstring);
            
        } else if ($subArg==='edit') {
            //edit the article
            
            if ($method==='POST') {
                echo $response = $article->editArticle($_POST);
            } else {
                $arr = array('Error' => 'Method should be post, but '.$method.' method received', 'Response' => false);
                echo json_encode($arr);
            }
            
        } else if ($subArg==='delete') {
            //delete the article
            
            $articleId = array_shift($request);
            echo $response = $article->deleteArticle($articleId);
            
        }
        
    } else if ($mainArg==='comment') {
        //edit or add the submitted argument information
        
        include_once('_class/comment.php');
        $comment = new comment();
        
        $subArg = array_shift($request);
        if ($subArg==='get') {
            
            $commentType = array_shift($request);
            if ($commentType==='article') {
                $artId = array_shift($request);
                echo $comments = $comment->getCommentsByArticleId($artId);
            } else if ($commentType==='user') {
                $userId = array_shift($request);
                echo $comments = $comment->getCommentsByUserId($userId);
            }
        } else if ($subArg==='add') {
            
            if ($method==='POST') {
                echo $response = $comment->addComment($_POST);
            } else {
                $arr = array('Error' => 'Method should be post, but '.$method.' method received', 'Response' => false);
                echo json_encode($arr);
            }
        }
        
    } else if ($mainArg==='test') {
        $arr = array('A' => 1, 'B' => 2, 'C' => 3, 'Response' => true);
        echo json_encode($arr);
    }
    else {
        $arr = array('Error' => 'Incorrect API arguments', 'Response' => false);
        echo json_encode($arr);
    }

?>