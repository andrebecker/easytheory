<?php
$url = htmlentities('http://'.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']);

require './logic/qa.php';
$qa = new QA();

$question = "";
$answer = "";
$comment = array();

// initialize htmltemplate	
require_once './generalClasses/htmltemplate.php';
$html = new HTMLtemplate();	
$htmlTemplate = array();

$htmlTemplate['active'] = 'Kurse';

$courseId = 0;
if(!empty($_GET['course'])) {

	$courseId = $_GET['course'];

}

$qaId = 0;
$qaId = $qa->getRandom($courseId);

$userId = 0;
if(!empty($GLOBALS['loggedIn'])) {
	
	$userId = $GLOBALS['loggedIn'];
	
}

require './logic/rating.php';
$rating = new Rating();

$myRating = 0;
$myRating = $rating -> getPersonalRating($qaId, $userId);

$htmlTemplate['content'] = '<section id="contentSingleSection"><article class="qaArticle"><div id="question">
    <header><div class="hgroup"><h3><a class="center" href="./index.php?go=addqa&amp;course='.$courseId.'">neue Frage hinzuf&uuml;gen</a></h3><h2>Frage</h2></div></header>
    <div class="questionLine">';
$question = $qa->showQuestion($qaId);
$cleanQuestion = preg_replace(array_keys($xss['out']), $xss['out'], $question);
$htmlTemplate['content'] .= $cleanQuestion;
$htmlTemplate['content'] .= '</div>
	<form method="post" action="./index.php?go=qa&amp;course='.$courseId.'"><input type="hidden" name="url" value="'.$url.'" /><input type="hidden" name="hiddenUserId" value="'.$userId.'" /><input type="hidden" name="hiddenQAId" value="'.$qaId.'" /><input type="hidden" name="hiddenIfMyRatingExists" value="'.$myRating.'" /><input type="button" class="answerAndNext" id="showAnswer" name="showAnswer" value="Antwort anzeigen" />
	<fieldset id="answerRating" class="rating">
    <legend>Antwort Bewerten:</legend>';

switch ($myRating) {
	 case 0:
        $htmlTemplate['content'] .= '<input type="radio" class="realVote" id="star5" name="rating" value="5" /><label class="labelRadio" for="star5" title="Sehr gut!">5 stars</label>
		<input type="radio" class="realVote" id="star4" name="rating" value="4" /><label class="labelRadio" for="star4" title="Gut">4 stars</label>
		<input type="radio" class="realVote" id="star3" name="rating" value="3" /><label class="labelRadio" for="star3" title="Befriedigend">3 stars</label>
		<input type="radio" class="realVote" id="star2" name="rating" value="2" /><label class="labelRadio" for="star2" title="Ausreichend">2 stars</label>
		<input type="radio" class="realVote" id="star1" name="rating" value="1" /><label class="labelRadio" for="star1" title="Mangelhaft">1 star</label>';
        break;
    case 1:
        $htmlTemplate['content'] .= '<input type="radio" class="realVote" id="star5" name="rating" value="5" /><label class="labelRadio" for="star5" title="Sehr gut!">5 stars</label>
		<input type="radio" class="realVote" id="star4" name="rating" value="4" /><label class="labelRadio" for="star4" title="Gut">4 stars</label>
		<input type="radio" class="realVote" id="star3" name="rating" value="3" /><label class="labelRadio" for="star3" title="Befriedigend">3 stars</label>
		<input type="radio" class="realVote" id="star2" name="rating" value="2" /><label class="labelRadio" for="star2" title="Ausreichend">2 stars</label>
		<input type="radio" checked class="realVote" id="star1" name="rating" value="1" /><label class="labelRadio" for="star1" title="Mangelhaft">1 star</label>';
        break;
    case 2:
        $htmlTemplate['content'] .= '<input type="radio" class="realVote" id="star5" name="rating" value="5" /><label for="star5" title="Sehr gut!">5 stars</label>
		<input type="radio" class="realVote" id="star4" name="rating" value="4" /><label for="star4" title="Gut">4 stars</label>
		<input type="radio" class="realVote" id="star3" name="rating" value="3" /><label for="star3" title="Befriedigend">3 stars</label>
		<input type="radio" checked class="realVote" id="star2" name="rating" value="2" /><label for="star2" title="Ausreichend">2 stars</label>
		<input type="radio" class="realVote" id="star1" name="rating" value="1" /><label for="star1" title="Mangelhaft">1 star</label>';
        break;
	 case 3:
        $htmlTemplate['content'] .= '<input type="radio" class="realVote" id="star5" name="rating" value="5" /><label for="star5" title="Sehr gut!">5 stars</label>
		<input type="radio" class="realVote" id="star4" name="rating" value="4" /><label for="star4" title="Gut">4 stars</label>
		<input type="radio" checked class="realVote" id="star3" name="rating" value="3" /><label for="star3" title="Befriedigend">3 stars</label>
		<input type="radio" class="realVote" id="star2" name="rating" value="2" /><label for="star2" title="Ausreichend">2 stars</label>
		<input type="radio" class="realVote" id="star1" name="rating" value="1" /><label for="star1" title="Mangelhaft">1 star</label>';
        break;
	 case 4:
        $htmlTemplate['content'] .= '<input type="radio" class="realVote" id="star5" name="rating" value="5" /><label for="star5" title="Sehr gut!">5 stars</label>
		<input type="radio" checked class="realVote" id="star4" name="rating" value="4" /><label for="star4" title="Gut">4 stars</label>
		<input type="radio" class="realVote" id="star3" name="rating" value="3" /><label for="star3" title="Befriedigend">3 stars</label>
		<input type="radio" class="realVote" id="star2" name="rating" value="2" /><label for="star2" title="Ausreichend">2 stars</label>
		<input type="radio" class="realVote" id="star1" name="rating" value="1" /><label for="star1" title="Mangelhaft">1 star</label>';
        break;
	 case 5:
        $htmlTemplate['content'] .= '<input type="radio" checked class="realVote" id="star5" name="rating" value="5" /><label for="star5" title="Sehr gut!">5 stars</label>
		<input type="radio" class="realVote" id="star4" name="rating" value="4" /><label for="star4" title="Gut">4 stars</label>
		<input type="radio" class="realVote" id="star3" name="rating" value="3" /><label for="star3" title="Befriedigend">3 stars</label>
		<input type="radio" class="realVote" id="star2" name="rating" value="2" /><label for="star2" title="Ausreichend">2 stars</label>
		<input type="radio" class="realVote" id="star1" name="rating" value="1" /><label for="star1" title="Mangelhaft">1 star</label>';
        break;
}

$avgRating = 0;
$avgRating = $rating -> getGlobalRating($qaId);
$cleanRating = preg_replace(array_keys($xss['out']), $xss['out'], $avgRating);
$htmlTemplate['content'] .= 'Durschnittliche Bewertung: '.$cleanRating;
$htmlTemplate['content'] .= '</fieldset>
	<input type="submit" class="answerAndNext"  name="nextQuestion" value="n&auml;chste Frage" />
    </div></article>';
$htmlTemplate['content'] .= '<article><div id="answer">
    <header><h2>Antwort</h2></header>
    <div>';
$answer = $qa->showAnswer($qaId);
$cleanAnswer = preg_replace(array_keys($xss['out']), $xss['out'], $answer);
$htmlTemplate['content'] .= $cleanAnswer;
$htmlTemplate['content'] .= '</div></div></article>';

$htmlTemplate['content'] .= '<article><div id="commentLink"><a id="displayAllComments" href="'.$url.'">Kommentar(e) einblenden</a><a id="addComments" href="'.$url.'">Kommentar verfassen</a><p>';
$htmlTemplate['content'] .= '<div class="outerCommentContainer"><div class="addComentTextField"><div class="fakeHgroupDark"><input typ="text" class="textMediumBig" id="addCommentInputField" name="addCommentInputField" placeholder="Hier den Kommentar einf&uuml;gen" /><input type="button" id="submitMyComment" name="submitMyComment" value="Kommentar abschicken" /></div></div></form><div class="commentDisplay">';
$htmlTemplate['content'] .= '<div class="commentContainer"></div>';
$htmlTemplate['content'] .= '</div></div></p></div></article></section>';
$html->createHTMLtemplate($htmlTemplate['active'], $htmlTemplate['content']);