<?php

require './logic/userFunctions.php';
$user = new User();

// initialize htmltemplate	
require_once './generalClasses/htmltemplate.php';
$html = new HTMLtemplate();	
$htmlTemplate = array();

$htmlTemplate['active'] = 'Registrierung';

$htmlTemplate['content'] = '<section id="contentSingleSection">
    <header><div class="hgroup"><h2>Registrierung</h2></div></header>
    <form method="post" action="./index.php?go=reg" name="tos">
	<p>deine E-mail Adresse:<br /><input type="email" name="email" class="emailCSS" maxlength="45" required pattern="^\w+([-+.\']\w+)*@uni-hildesheim.de$" /><span class="validityIndicator"></span></p>
	<p>dein gew&uuml;nschtes Passwort:<br /><input type="password" name="regPw" required /></p>
	<p>bitte wiederhole dein gew&uuml;nschtes Passwort:<br /><input type="password" name="regPwAgain" required /></p>
	<br />
	<p><input type="checkbox" name="tosCheck" id="tosCheck" /> Ich habe die AGB gelesen, und akzeptiere diese.</p>
	<br>
	<p><input type="submit" name="submitReg" id="submitReg" value="registrieren" disabled /></p></form>';

if(!empty($_POST['submitReg'])) {

	$error = '';
	$emailAlreadyInUse = false;
	$email =  '';
	$regPw = '';
	$regPwAgain = '';
	
	if(!empty($_POST['email'])) {
	
		$email = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['email']);
		
		require './generalClasses/generalFunctions.php';
		$generalFunction = new GeneralFunction();
		$checkEndOfString = false;
		
		$checkEndOfString = $generalFunction -> endsWith($email, '@uni-hildesheim.de');
		
		if(!$checkEndOfString) {
		
			$error .= '<li>Nur @uni-hildesheim.de - Addressen sind erlaubt!</li>';
		
		} 
		
	}else{
	
		$error .= '<li>Bitte geben Sie Ihre E-mail Adresse ein!</li>';
		
	}
	
	if(!empty($_POST['regPw'])) {
	
		$regPw = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['regPw']);
		
	}else{
	
		$error .= '<li>Bitte geben Sie Ihr Passwort ein!</li>';
		
	}
	
	if(!empty($_POST['regPwAgain'])) {
	
		$regPwAgain = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['regPwAgain']);
		
	}else{
	
		$error .= '<li>Bitte geben Sie Ihr Passwort erneut ein!</li>';
		
	}
	
	if($regPw != $regPwAgain) {
	
		$error .= '<li>Ihre eingebenen Passw&ouml;rter stimmen nicht &uuml;berein!</li>';
		
	}
	
	$emailAlreadyInUse = $user -> checkEmail($email); 
	
	if($emailAlreadyInUse == true) {
	
		$error .= 'Ihre E-mail Addresse wird bereits genutzt!';
	
	}
	
	if(!empty($error)) {
	
		$htmlTemplate['content'] .= '<p><div class="errorMsg">Bei Ihrer Anmeldung ist ein Fehler aufgetreten. Gr&uuml;nde:
			<ul>'.$error.'</ul></div></p>';
	
	} else {
	
		$creationSuccessful = false;
		$creationSuccessful = $user -> createAccount($email, $regPw); 
		
		if($creationSuccessful == true) {
		
			$htmlTemplate['content'] .= '<div class="successMsg">Ihre Registrierung war erfolgreich. 
			Zu Best&auml;tigung haben wir Ihnen eine E-Mail zugeschickt. Diese beinhaltet einen Link, den Sie einmalig als Best&auml;tigung anklicken m&uuml;ssen.
			<br /><a href="./index.php">Zur Startseite</a></div>';
		
		} else {
		
			$htmlTemplate['content'] .= '<p><div class="errorMsg">Bei Ihrer Anmeldung ist ein Fehler aufgetreten.</div></p>';
		
		}

	}
	
}

$htmlTemplate['content'] .= '</section>';

$html->createHTMLtemplate($htmlTemplate['active'], $htmlTemplate['content']);