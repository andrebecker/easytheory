<?php

require './logic/course.php';
$course = new Course();

// initialize htmltemplate	
require_once './generalClasses/htmltemplate.php';
$html = new HTMLtemplate();	
$htmlTemplate = array();

$htmlTemplate['active'] = 'Kurse';

$courseId = 0;
$courseName = '';
$courseArray = array();

$htmlTemplate['content'] = '<section id="contentSingleSection">
    <header><div class="hgroup"><h3><a class="center" href="./index.php?go=addcourse">neuen Kurs anlegen</a></h3><h2>Kursverzeichnis</h2></div></header>';
	
$courseArray = $course -> showCourses();
$sizeOfCourseArray = sizeof($courseArray[0]);
for($i=0; $i<$sizeOfCourseArray; $i++) {

	if($i%2 != 0) {
		$htmlTemplate['content'] .= '<div class="fakeHgroupBright"><a href="./index.php?go=qa&amp;course='.$courseArray[0][$i].'">'.$courseArray[1][$i].'</a></div>';
	} else {
		$htmlTemplate['content'] .= '<div class="fakeHgroupDark"><a href="./index.php?go=qa&amp;course='.$courseArray[0][$i].'">'.$courseArray[1][$i].'</a></div>';
	}
	
}

$htmlTemplate['content'] .= '</section>';
$html->createHTMLtemplate($htmlTemplate['active'], $htmlTemplate['content']);