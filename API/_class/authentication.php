<?php


class auth {

	public function getChallenge($url) {
		
    $nonce = uniqid();
    $realm = md5($url);
    $qop = md5('auth');
    $opaque = md5($realm);
    
    return array('status' => 'authentication required' , 'nonce' => $nonce);
	}
	
	
	
	public function validateDigest($response, $nonce, $url, $username) {
		
		//get md5 hashes of inputs
		$qop = md5('auth');
		$realm = md5($url);
		$opaque = md5($realm);
		
		//call to database connection
    include_once('dbConnection.php');
    $db = new databaseConnection();
    
    //form query
    $query = "
        SELECT password
        FROM User
        WHERE name = '$username'";
    
    //do query
    $result = $db->queryDatabase($query);

    $password = $result->fetch_assoc()['password'];
		
		$expected_response = $qop . $realm . $opaque . $nonce . $password;
		$expected_response = md5($expected_response);
		
		if ($expected_response === $response) {
			return $expected_response;
		} else {
			return $expected_response;
		}
		
		
	}




}




?>