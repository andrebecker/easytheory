<?php

// save the users answer-rating
if(!empty($_POST['rating']) && !empty($_POST['userId']) && !empty($_POST['questionId'])) {

	require_once './index.php';
	
	if(empty($_POST['earlierRating'])) {
	
		$params = array($_POST['userId'], $_POST['questionId'], $_POST['rating']);
		$query = "INSERT INTO et_rating(et_rating_submitter, et_rating_qa_id, et_rating_vote) VALUES(?, ?, ?);";
		
	} else {
	
		$params = array($_POST['rating'], $_POST['userId'], $_POST['questionId']);
		$query = "UPDATE et_rating SET et_rating_vote=? WHERE et_rating_submitter=? AND et_rating_qa_id=?;";
		
	}
	$res = $GLOBALS['db'] -> execute($query, $params);
		
	$return['succes'] = '';

	// check if insertion was successful
	if($res['rows'] > 0) {
		
		$return['succes'] = 'true';
		  
	}

    echo json_encode($return);
    exit;

}

class Rating {

	function getGlobalRating($qaId) {
	
		require_once './index.php';

        $params = array($qaId);
        $query = "SELECT AVG(et_rating_vote) AS averageRating FROM et_rating WHERE et_rating_qa_id = ?;";
        $res = $GLOBALS['db'] -> row($query, $params);

		$averageRating = 0;

		if($res['rows']>0) {
		
			$averageRating = $res['result']['averageRating'];
			
		}
		
        return $averageRating;
	
	}
	
	function getPersonalRating($qaId, $userId) {
	
		require_once './index.php';

        $params = array($qaId, $userId);
        $query = "SELECT et_rating_vote FROM et_rating WHERE et_rating_qa_id = ? AND et_rating_submitter = ?;";
        $res = $GLOBALS['db'] -> row($query, $params);

		$personalRating = 0;

		if($res['rows']>0) {
		
			$personalRating =  (int) $res['result']['et_rating_vote'];
			
		}
		
        return $personalRating;
	
	}

}