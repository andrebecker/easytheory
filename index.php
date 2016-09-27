<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

error_reporting(-1);

header('P3P: CP=”NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM”');

header('Set-Cookie: SIDNAME=ronty; path=/; secure');

header('Cache-Control: no-cache');

header('Pragma: no-cache');

session_start();

/*
 * Config 
 */
$conf = array(
	'host' => 'localhost',
	'bank' => 'easytheory',
	'user' => 'root',
	'pass' => 'mysql1',
);

/*
 * db class 
 */
require './generalClasses/db.php';

// connect to db
$GLOBALS['db'] = new db($conf['host'], $conf['bank'], $conf['user'], $conf['pass'], 'mysql');

/*
 * Regex Replaces
 */
$xss = array(

	'in' => array(

		'/&lt;(script[^>]*)&gt;/i' => '<$1>',
		'/&lt;\/(script)&gt;/i' => '<\/$1>',

		'/on([^=]+)=&quot;([^"]*)&quot;/i' => 'on$1="$2"',
		   
		'/&quot;(javascript:[^"]*)&quot;/i' => '"$1"',
	),

	'out' => array(

		'/<(script[^>]*)>/i' => '&lt;$1&gt;',
		'/<\/(script)>/i' => '&lt;/$1&gt;',

		'/on([^=]+)="([^"]*)"/i' => 'on$1=&quot;$2&quot;',
		'/on([^=]+)=\'([^"]*)\'/i' => 'on$1=&quot;$2&quot;',

		'/"(javascript:[^"]*)"/i' => '&quot;$1&quot;',
		'/\'(javascript:[^"]*)\'/i' => '&quot;$1&quot;',
	),
);

// assign session userId to a global variable
if(!empty($_SESSION['userId'])) {
	$GLOBALS['loggedIn'] = $_SESSION['userId'];
}

if(!empty($_GET['go'])) {

	if($_GET['go'] == 'qa' && !empty($GLOBALS['loggedIn'])) {
		require './output/out_qa.php';
		exit;
	} else if($_GET['go'] == 'addqa' && !empty($GLOBALS['loggedIn'])) {
		require './output/out_addQuestion.php';
		exit;
	} else if($_GET['go'] == 'reg') {
		require './output/out_registration.php';
		exit;
	} else if($_GET['go'] == 'courses' && !empty($GLOBALS['loggedIn'])) {
		require './output/out_course.php';
		exit;
	}  else if($_GET['go'] == 'addcourse' && !empty($GLOBALS['loggedIn'])) {
		require './output/out_addCourse.php';
		exit;
	} else if($_GET['go'] == 'out' && !empty($GLOBALS['loggedIn'])) {
		require './output/out_logout.php';
		exit;
	}

}

// initialize htmltemplate	
require_once './generalClasses/htmltemplate.php';
$html = new HTMLtemplate();	
$htmlTemplate = array();

$htmlTemplate['active'] = 'home';

$htmlTemplate['content'] = '<section id="content"><div class="hgroup"><h2>Willkommen bei easytheory.net!</h2><h3>der bequemen Art zu lernen</h3></div>';
$htmlTemplate['content'] .= '<p>Du lernst tagelang jede erdenkliche Definition aus dem Skript auswendig und in der Klausur wird dann etwas abgefragt, welches der Dozent erl&auml;uterte als die meisten schon die Vorlesung verlassen hatten. ';
$htmlTemplate['content'] .= 'Entt&auml;uscht gibst du die Klausur ab und hast durch so eine Kleinigkeit eine schlechtere Note, eventuell bist du deswegen sogar durchgefallen. ';
$htmlTemplate['content'] .= 'So erging es mir auch und da kam mir die Idee: Eine Website auf der alle Kursteilnehmer m&ouml;gliche Klausurfragen mit zugeh&ouml;hriger L&ouml;sung posten k&ouml;nnen. ';
$htmlTemplate['content'] .= 'So verpasst man nie wieder eine Frage und die n&auml;chste Klausur wird um einiges einfacher zu schaffen</p>';
$htmlTemplate['content'] .= '<p>PS: Damit niemand etwas falsches lernt, weil jemand etwas falsch verstanden hat und entsprechend auch eine fehlerbehaftete L&ouml;sung gepostet hat, k&ouml;nnen alle die jeweilige Antwort bewerten.';
$htmlTemplate['content'] .= 'So seht Ihr sofort, an welcher Stelle ihr vielleicht doch nochmal in euren Unterlagen nachschlagen solltet.</p>';
$htmlTemplate['content'] .= '<div class="infoMsg"><h4>Hinweis</h4><p>Dieser Service ist momentan ausschlie&szlig;lich f&uuml;r Studierende der Uni Hildesheim.</p>';
$htmlTemplate['content'] .= '<p>Dieser Umstand soll sich jedoch bald &auml;ndern.</p></div></section>';
$htmlTemplate['content'] .= '<aside id="aside"><div class="hgroup"><h3>Login</h3></div><br /><div class="login"><form method="post" action="./index.php">';
$htmlTemplate['content'] .= '<p>Email:<br /><input type="email" required name="emailaddress" maxlength="45" class="emailCSS" pattern="^\w+([-+.\']\w+)*@uni-hildesheim.de$"/><span class="validityIndicator"></span></p>';
$htmlTemplate['content'] .= '<p>Passwort:<br /><input type="password" required maxlength="45" name="loginpw" class="textstandard" /></p>';
$htmlTemplate['content'] .= '<p><input type="submit" name="loginBtn" value="Einloggen" /></p></form>';
$htmlTemplate['content'] .= '<p><a href="./index.php?go=reg">registrieren</a></p>';

if(!empty($_POST['loginBtn'])) {

	require './logic/userFunctions.php';
	$user = new User();
	$email =  '';
	$loginpw = '';
	$error = '';
	
	if(!empty($_POST['emailaddress'])) {
	
		$email = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['emailaddress']);
		
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
	
	if(!empty($_POST['loginpw'])) {
	
		$loginpw = preg_replace(array_keys($xss['in']), $xss['in'], $_POST['loginpw']);
		
	}else{
	
		$error .= '<li>Bitte geben Sie Ihr Passwort ein!</li>';
		
	}
	
	if($error != '') {
	
		$htmlTemplate['content'] .= '<p>Bei Ihrem Login ist ein Fehler aufgetreten. Gr&uuml;nde:
			<ul><div class="errorMsg">'.$error.'</div></ul></p>';
	
	} else {
	
		$loginSuccessful = false;
		$loginSuccessful = $user -> getLogin($email, $loginpw);
		
		if($loginSuccessful == true) {
			
			header('Location: http://localhost/easytheory/index.php?go=courses') ;
			exit;
		
		} else {
		
			$htmlTemplate['content'] .= '<p><div class="errorMsg">Bei Ihrem Login ist ein Fehler aufgetreten.</div></p>';
		
		}
	
	}

}

$htmlTemplate['content'] .= '</div></aside>';

$html->createHTMLtemplate($htmlTemplate['active'], $htmlTemplate['content']);
 