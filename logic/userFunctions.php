<?php

class User {

	// check if password is correct
	public function getLogin($email, $pw) {
	
		require_once './index.php';
  
		$cleanpw = crypt(md5($email), md5($pw));
		$params = array($email, $cleanpw);
		$query = "SELECT et_users_role, et_users_id FROM et_users WHERE et_users_email = ? AND et_users_password = ?;";
		$res = $GLOBALS['db'] -> row($query, $params);
		
		$login = false;
		$userId = 0;
		$userRole = 'u';

		// if password is correct
		if($res['rows']>0) {
		
			$login = true;
			$userId = $res['result']['et_users_id'];
			$userRole = $res['result']['et_users_role'];
			
			// register session 
			$_SESSION['role'] = $userRole;
			$_SESSION['userId'] = $userId;
		  
		}

		return $login;
    
	}
	
	// check if email is already in use
	public function checkEmail($email) {
	
		require_once './index.php';
    
		$params = array($email);
		$query = "SELECT * FROM et_users WHERE et_users_email = ?;";
		$res = $GLOBALS['db'] -> row($query, $params);
		
		$alreadyUsed = false;
		
		// if email is already in use
		if($res['rows']>0) {
		
			$alreadyUsed = true;
			
		}
		
		return $alreadyUsed;
    
	}
	
	// create a new account
	public function createAccount($email, $pw) {
	
		require_once './index.php';
    
		$cleanpw = crypt(md5($email), md5($pw));
		$params = array($email, $cleanpw);
		$query = "INSERT INTO et_users(et_users_email, et_users_password) VALUES(?, ?);";
		$res = $GLOBALS['db'] -> execute($query, $params);
		
		$succes = false;

		// check if creation was successful
		if($res['rows']>0) {
		
			$succes = true;
		  
		}
		
		return $succes;
    
	}

}