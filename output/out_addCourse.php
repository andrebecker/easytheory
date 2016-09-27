<?php

// initialize htmltemplate	
require_once './generalClasses/htmltemplate.php';
$html = new HTMLtemplate();	
$htmlTemplate = array();

$htmlTemplate['active'] = 'Kurse';

$courseId = 0;
$courseName = '';
$courseArray = array();

$htmlTemplate['content'] = '<section id="contentSingleSection">
    <header><div class="hgroup"><h2>einen Neuen Kurs anlegen</h2></div></header>';
$htmlTemplate['content'] .= '<form method="post" action="./index.php?go=addcourse"><article><input type="text" maxlength="45" required class="textBig" name="courseName" placeholder="Bitte hier den Kursnamen eintragen!" /></article>';
$htmlTemplate['content'] .= '<article><input type="submit" name="courseSubmit" id="courseSubmit" value="Kurs erstellen" /></article></form>';

if(!empty($_POST['courseSubmit'])) {

	$error = '';
	$courseName = '';
	$courseAlreadyExists = false;
	
	require './logic/course.php';
	$course = new Course();
	
	if(!empty($_POST['courseName'])) {
	
		$courseName = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['courseName']);
		
	}else{
	
		$error .= '<li>Bitte geben Sie den Kursnamen ein!</li>';
		
	}
	
	$courseAlreadyExists = $course -> checkCourseExistence($courseName);
	
	if($courseAlreadyExists == true) {
	
		$error .= 'Der angegebene Kurs existiert bereits!';
	
	}

	if(!empty($error)) {
	
		$htmlTemplate['content'] .= '<p><div class="errorMsg">Bei der Erstellung des Kurses ist ein Fehler aufgetreten. Gr&uuml;nde:
			<ul>'.$error.'</ul></div></p>';
	
	} else {
	
		$courseCreationSuccessful = false;
		$courseCreationSuccessful = $course -> insertCourse($courseName); 
		
		if($courseCreationSuccessful == true) {
		
			$htmlTemplate['content'] .= '<div class="successMsg">Die Kurserstellung war erfolgreich. 
			Der von Ihnen eingegebene Kurs ist ab sofort im <a href="./index.php?go=courses">Kursverzeichnis</a> verf&uuml;gbar.</div>';
		
		} else {
		
			$htmlTemplate['content'] .= '<p><div class="errorMsg">Bei der Erstellung des Kurses ist ein Fehler aufgetreten.</div></p>';
		
		}

	}
	
}

$htmlTemplate['content'] .= '</section>';
$html->createHTMLtemplate($htmlTemplate['active'], $htmlTemplate['content']);