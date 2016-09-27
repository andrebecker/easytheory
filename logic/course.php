<?php
class Course {

	function getCourseName($courseId) {
        require_once './index.php';

        $params = array($courseId);
        $query = "SELECT et_courses_name FROM et_courses WHERE et_courses_id=?;";
        $res = $GLOBALS['db'] -> row($query, $params);

		$courseName = '';

		if($res['rows']>0) {
		
			$courseName = $res['result']['et_courses_name'];
			
		}

			
        return $courseName;
    }
	
	function showCourses() {
        require_once './index.php';

        $params = array();
        $query = "SELECT et_courses_id, et_courses_name FROM et_courses;";
        $res = $GLOBALS['db'] -> all($query, $params);

		$courseIdList = array();
		$courseName = array();

        for($i=0;$i<$res['rows'];$i++) {
		
			$courseId[$i] = $res['result'][$i]['et_courses_id'];
			$courseName[$i] = $res['result'][$i]['et_courses_name'];

		}
		
		$courseList = array($courseId, $courseName);
			
        return $courseList;
    }
	
	// check if course already exists
	public function checkCourseExistence($courseName) {
	
		require_once './index.php';
    
		$params = array($courseName);
		$query = "SELECT * FROM et_courses WHERE et_courses_name = ?;";
		$res = $GLOBALS['db'] -> row($query, $params);
		
		$alreadyExists = false;
		
		// course already exists
		if($res['rows']>0) {
		
			$alreadyExists = true;
			
		}
		
		return $alreadyExists;
    
	}
	
	function insertCourse($courseName) {
        require_once './index.php';

		$params = array($courseName);
		$query = "INSERT INTO et_courses(et_courses_name) VALUES(?);";
		$res = $GLOBALS['db'] -> execute($query, $params);
		
		$succes = false;

		// check if insertion was successful
		if($res['rows']>0) {
		
			$succes = true;
		  
		}
		
		return $succes;
    }

}