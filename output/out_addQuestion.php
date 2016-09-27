<?php

// initialize htmltemplate	
require_once './generalClasses/htmltemplate.php';
$html = new HTMLtemplate();	
$htmlTemplate = array();

$htmlTemplate['active'] = 'Kurse';

$associatedCourseId = 0;
if(!empty($_GET['course'])) {

	$associatedCourseId = $_GET['course'];

	require './logic/course.php';
	$course = new Course();
	$associatedCourseName = '';
	$associatedCourseName = $course -> getCourseName($associatedCourseId);

}


$htmlTemplate['content'] = '<section id="contentSingleSection">
    <header><div class="hgroup"><h2>neue Frage und Antwort speichern</h2></div></header>';
$htmlTemplate['content'] .= '<form method="post" action="./index.php?go=addqa&amp;course='.$associatedCourseId.'"><article><textarea name="questionArea" required class="areaBig" placeholder="Bitte hier den Fragetext eingeben!"></textarea><img src="./icons/question.png" alt="" /></article>';
$htmlTemplate['content'] .= '<article><textarea name="answerArea" required class="areaBig" placeholder="Bitte hier den Antworttext eingeben!"></textarea><img src="./icons/Knob Valid Green.png" alt="" /></article>';
$htmlTemplate['content'] .= '<article><input type="text" name="courseField" readonly required maxlength="45" class="textBig" value="';
	
$htmlTemplate['content'] .= $associatedCourseName.'" /></article>';
$htmlTemplate['content'] .= '<article><input type="submit" name="qaSubmit" id="qaSubmit" value="Senden" /></article></form>';

if(!empty($_POST['qaSubmit'])) {

	$error = '';
	$question = '';
	$answer = '';
	$userId = 0;
	
	if(!empty($GLOBALS['loggedIn'])) {
	
		$userId = $GLOBALS['loggedIn'];
	
	}
	
	if(!empty($_POST['questionArea'])) {
	
		$question = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['questionArea']);
		
	}else{
	
		$error .= '<li>Bitte geben Sie den Fragetext ein!</li>';
		
	}
	
	if(!empty($_POST['answerArea'])) {
	
		$answer = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['answerArea']);
		
	}else{
	
		$error .= '<li>Bitte geben Sie den Antworttext ein!</li>';
		
	}
	
	if(!empty($error)) {
	
		$htmlTemplate['content'] .= '<p><div class="errorMsg">Bei der Erstellung der Frage ist ein Fehler aufgetreten. Gr&uuml;nde:
			<ul>'.$error.'</ul></div></p>';
	
	} else {
	
		require './logic/qa.php';
		$qa = new QA();

		$questionCreationSuccessful = false;
		$questionCreationSuccessful = $qa -> insertQuestion($userId, $associatedCourseId, $question, $answer); 
		
		if($questionCreationSuccessful == true) {
		
			$htmlTemplate['content'] .= '<div class="successMsg">Die Frageerstellung war erfolgreich. 
			Die von Ihnen eingegebene Frage mit zugeh&ouml;hriger Antwort ist ab sofort im Frage-/Antwortsatz von <a href="./index.php?go=qa&amp;course='.$associatedCourseId.'">'.$associatedCourseName.'</a>.</div>';
		
		} else {
		
			$htmlTemplate['content'] .= '<p><div class="errorMsg">Bei der Erstellung der Frage ist ein Fehler aufgetreten.</div></p>';
		
		}

	}
	
}

$htmlTemplate['content'] .= '</section>';
$html->createHTMLtemplate($htmlTemplate['active'], $htmlTemplate['content']);