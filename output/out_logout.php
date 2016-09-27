<?php

session_destroy();

// initialize htmltemplate	
require_once './generalClasses/htmltemplate.php';
$html = new HTMLtemplate();	
$htmlTemplate = array();

$htmlTemplate['active'] = 'Logout';

$htmlTemplate['content'] = '<script type="text/javascript">
	var delay = 3000; 

	setTimeout(function(){ window.location ="./index.php"; }, delay);
	</script>
	
	<section id="contentSingleSection">
    <header><div class="hgroup"><h2>Logout</h2></div></header>
	<div class="infoMsg">Sie wurden erfolgreich ausgeloggt und werden nun zur Startseite weitergeleitet!</div></section>';
$html->createHTMLtemplate($htmlTemplate['active'], $htmlTemplate['content']);