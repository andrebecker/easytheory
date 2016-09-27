<?php

// save the users comment
if(!empty($_POST['commentText']) && !empty($_POST['userId']) && !empty($_POST['questionId'])) {

	require_once './index.php';
	
	$cleanComment = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['commentText']);
	
	$params = array($cleanComment, $_POST['questionId'], $_POST['userId']);
	$query = "INSERT INTO et_comments(et_comments_content, et_comments_qa_id, et_comments_submitter) VALUES(?, ?, ?);";
	$res = $GLOBALS['db'] -> execute($query, $params);
		
	$return['succes'] = '';

	// check if insertion was successful
	if($res['rows'] > 0) {
		
		$return['succes'] = 'true';
		  
	}

    echo json_encode($return);
    exit;

}

// fetch all users comments
if(empty($_POST['commentText']) && !empty($_POST['questionId']) && empty($_POST['rating'])) {

	require_once './index.php';

    $params = array($_POST['questionId']);
    $query = "SELECT et_comments_content FROM et_comments WHERE et_comments_qa_id=?;";
    $res = $GLOBALS['db'] -> all($query, $params);

	$comments = array();
	
    for($i=0;$i<$res['rows'];$i++) {
		
		$comments[$i] = $res['result'][$i]['et_comments_content'];

	}
			
	$cleanComment = preg_replace(array_keys($xss['out']), $xss['out'], $comments);
    echo json_encode($cleanComment);
	exit;

}

class QA {
	
	function getRandom($courseId) {
        require_once './index.php';

        $params = array($courseId, $courseId);
        $query = "SELECT et_qa_id FROM et_qa WHERE et_qa_course_id=? AND et_qa_id >= RAND() * (SELECT MAX(et_qa_id) FROM et_qa WHERE et_qa_course_id=?) LIMIT 1;";
        $res = $GLOBALS['db'] -> row($query, $params);

		$random_id = "";

        if($res['rows']>0) {
            
			$random_id = $res['result']['et_qa_id'];
			
        }
			
        return $random_id;
    }
	
    function showQuestion($qaId) {
        require_once './index.php';

        $params = array($qaId);
		
        $query = "SELECT et_qa_question FROM et_qa WHERE et_qa_id=?;";
        $res = $GLOBALS['db'] -> row($query, $params);

		$question = "";

        if($res['rows']>0) {
            
			$question = $res['result']['et_qa_question'];
			
        }
			
        return $question;
    }
	
	function showAnswer($qaId) {
        require_once './index.php';

        $params = array($qaId);
        $query = "SELECT et_qa_answer FROM et_qa WHERE et_qa_id=?;";
        $res = $GLOBALS['db'] -> row($query, $params);

		$answer = "";

        if($res['rows']>0) {
            
			$answer = $res['result']['et_qa_answer'];
			
        }
			
        return $answer;
    }
	
	function insertQuestion($userId, $courseId, $question, $answer) {
        require_once './index.php';

		$params = array($userId, $courseId, $question, $answer);
		$query = "INSERT INTO et_qa(et_qa_submitter, et_qa_course_id, et_qa_question, et_qa_answer) VALUES(?, ?, ?, ?);";
		$res = $GLOBALS['db'] -> execute($query, $params);
		
		$succes = false;

		// check if insertion was successful
		if($res['rows']>0) {
		
			$succes = true;
		  
		}
		
		return $succes;
    }
	
	/*function showComment($qaId) {
        require_once './index.php';

        $params = array($qaId);
        $query = "SELECT et_comments_content FROM et_comments WHERE et_comments_qa_id=?;";
        $res = $GLOBALS['db'] -> all($query, $params);

		$comments = array();

        for($i=0;$i<$res['rows'];$i++) {
		
			$comments[$i] = $res['result'][$i]['et_comments_content'];

		}
			
        return $comments;
    }
	
	function insertComment($userId, $content, $qaId) {
        require_once './index.php';

		$params = array($userId, $content, $qaId);
		$query = "INSERT INTO et_comments(et_comments_submitter, et_comments_content, et_comments_qa_id) VALUES(?, ?, ?);";
		$res = $GLOBALS['db'] -> execute($query, $params);
		
		$succes = false;

		// check if insertion was successful
		if($res['rows']>0) {
		
			$succes = true;
		  
		}
		
		return $succes;
    }*/

}