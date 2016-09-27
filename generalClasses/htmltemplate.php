<?php
class HTMLtemplate {

	public function createHTMLtemplate($activeTag="", $content=array()) {

			echo 	'<!DOCTYPE html>
					<html lang="de">
					<head>
						<meta charset="utf-8" />
						<meta name="description" content="help me learn theory for collegelessons">
						<meta name="keywords" content="learning,college,school">
						<meta name="author" content="André Becker">
						<title>easy Theory</title>
						<link rel="stylesheet" href="./css/main.css" type="text/css" />
						<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
						<script src="./js/displayHide.js" type="text/javascript"></script>
						<script src="./js/activateDeactivate.js" type="text/javascript"></script>
						<script src="./js/answerRating.js" type="text/javascript"></script>
						<script src="./js/insertRetrieveComment.js" type="text/javascript"></script>
					</head>
					<body>
						<div id="doc">
							<header id="header">
								<h1>easytheory.net</h1>
								<nav>
								  <ul>';
								if($activeTag == 'home') {
									echo '<li class="active"><a href="./index.php">Home</a></li>';
									if(!empty($GLOBALS['loggedIn'])) {
										echo '<li style="padding-left:4px;"><a href="./index.php?go=courses">Kurse</a></li>
										<li><a href="./index.php?go=out">Logout</a></li>';
									}
								} else if($activeTag == 'Kurse'){
									echo '<li><a href="./index.php">Home</a></li>';
									if(!empty($GLOBALS['loggedIn'])) {
										echo '<li class="active" style="padding-left:4px;"><a href="./index.php?go=courses">Kurse</a></li>
										<li><a href="./index.php?go=out">Logout</a></li>';
									}
								} else {
									echo '<li><a href="./index.php">Home</a></li>';
									if(!empty($GLOBALS['loggedIn'])) {
										echo '<li style="padding-left:4px;"><a href="./index.php?go=courses">Kurse</a></li>
										<li class="active"><a href="./index.php?go=out">Logout</a></li>';
									}
								}
								echo ' </ul>
								</nav>
							</header><noscript>Sie m&uuml;ssen Javascript aktivieren um diese Seite nutzen zu k&ouml;nnen!</noscript> ';
							echo $content;
							echo '<footer>
								<a href="#" id="showImprint">Impressum</a>
								<div id="imprint">
								<b>Kontakt & Impressum</b><br />
								easytheory.net<br />
								Andr&eacute; Becker<br />
								Vivaldistra&szlig;e 4, 37154 Northeim<br />
								<br />
								Bitte beachten Sie unsere Datenschutzrichtlinie sowie unsere Nutzungsbedingungen!
								<br />
								<h1>Disclaimer – rechtliche Hinweise</h1>
								<strong>* Haftungsbeschränkung für eigene Inhalte</strong> Alle Inhalte unseres Internetauftritts wurden mit Sorgfalt und nach bestem Gewissen erstellt. Eine Gewähr für die Aktualität, Vollständigkeit und Richtigkeit sämtlicher Seiten kann jedoch nicht übernommen werden. Gemäß § 7 Abs. 1 TMG sind wir als Dienstanbieter für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich, nach  den §§ 8 bis 10 TMG jedoch nicht verpflichtet, die übermittelten oder gespeicherten fremden Informationen zu überwachen. Eine umgehende Entfernung dieser Inhalte erfolgt ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung und wir haften nicht vor dem Zeitpunkt der Kenntniserlangung.<br />
								<strong>* Haftungsbeschränkung für externe Links</strong> Unsere Webseite enthält sog. „externe Links“ (Verknüpfungen zu Webseiten Dritter), auf deren Inhalt wir keinen Einfluss haben und für den wir aus diesem Grund keine Gewähr übernehmen. Für die Inhalte und Richtigkeit der Informationen ist der jeweilige Informationsanbieter der verlinkten Webseite verantwortlich. Als die Verlinkung vorgenommen wurde, waren für uns keine Rechtsverstöße erkennbar. Sollte uns eine Rechtsverletzung bekannt werden, wird der jeweilige Link umgehend von uns entfernt.<br />
								<strong>* Urheberrecht</strong> Die auf dieser Webseite veröffentlichten Inhalte und Werke unterliegen dem deutschen Urheberrecht. Jede Art der Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechts bedarf der vorherigen schriftlichen Zustimmung des jeweiligen Urhebers bzw. Autors.<br />
								<strong>* Datenschutz</strong> Durch den Besuch unseres Internetauftritts können Informationen über den Zugriff (Datum, Uhrzeit, aufgerufene Seite) auf dem Server gespeichert werden. Dies stellt keine Auswertung personenbezogener Daten (z.B. Name, Anschrift oder E-Mail Adresse) dar. Sofern personenbezogene Daten erhoben werden, erfolgt dies – sofern möglich – nur mit dem vorherigen Einverständnis des Nutzers der Webseite. Eine Weiterleitung der Daten an Dritte findet ohne ausdrückliche Zustimmung des Nutzers nicht statt. Wir weisen ausdrücklich darauf hin, dass die Übertragung von Daten im Internet (z.B. per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff Dritter kann nicht gewährleistet werden. Wir können keine Haftung für die durch solche Sicherheitslücken entstehenden Schäden übernehmen. Der Verwendung veröffentlichter Kontaktdaten durch Dritte zum Zwecke von Werbung wird ausdrücklich widersprochen. Wir behalten uns rechtliche Schritte für den Fall der unverlangten Zusendung von Werbeinformationen, z.B. durch Spam-Mails, vor.<br />
								<strong>Quelle</strong>: <a href="http://www.mustervorlage.net/">mustervorlage.net</a> – <a href="http://www.mustervorlage.net/gedichte">Kostenlose Gedichte, Disclaimer & mehr</a>
								</div>
							</footer>
						</div>
					</body>
				</html>';

	}

}