<?php
require_once('BDD_Manager.php');

$message_erreur = '';
$message_info = '';
$message_erreur = '';
$gagne = false;

if(isset($_GET['btnJouer'])) {
	if($_GET['mise'] < 0) {
		$message_erreur = 'La mise doit être positive';
	} else if($_GET['mise'] == 0) {
		$message_erreur = 'Il faut miser de l\'argent ...';
	} else if($_GET['mise'] > $_SESSION['joueur_argent']) {
		$message_erreur = 'On ne mise pas plus que ce qu\'on a ...';
	} else if($_GET['numero'] == 0 && !isset($_GET['parite'])) {
		$message_erreur = 'Il faut miser sur quelquechose!';
	} else {
		$_SESSION['joueur_argent'] -= $_GET['mise'];
		$gain = 0;
		$numero = rand(1, 36);

		$miseJoueur = intval($_GET['mise']);
		$numeroJoueur = intval($_GET['numero']);
		$message_info = "La bille s'est arrêtée sur le $numero! ";
		if($_GET['numero']!= 0) {
			$message_info .= "Vous avez misé sur le ".$numeroJoueur."!";
			if($numeroJoueur == $numero) {
				$message_resultat = "Jackpot! Vous gagnez ". $miseJoueur*35 ."€ !";
				$gagne = true;
				$gain = $miseJoueur*35;
				$_SESSION['joueur_argent'] += $gain;
			} else {
				$message_resultat = "Raté!";
			}
		} else {
			$message_info .= "Vous avez misé sur le fait que le résultat soit ".$_GET['parite'];
			$parite = $numero%2 == 0 ? 'pair' : 'impair';
			if($parite == $_GET['parite']) {
				$message_resultat = "Bien joué! Vous gagnez ". $miseJoueur*2 ."€ !";
				$gagne = true;
				$gain = $miseJoueur*2;
				$_SESSION['joueur_argent'] += $gain;
			} else {
				$message_resultat = "C'est perdu, dommage!";
			}
		}
		majUtilisateur($_SESSION['joueur_id'], $_SESSION['joueur_argent']);
		ajoutePartie($_SESSION['joueur_id'], date('Y-m-d h:i:s'), $_GET['mise'], $gain);
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Roulette</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<header id="head">
	<h2 class="alert alert-warning">Jeu de la roulette</h2>
</header>
<br>
<?php 
if($message_erreur != '')
		echo "<div class=\"alert alert-danger errorMessage\">$message_erreur</div>";

if($message_info != '') {
	echo "<div class=\"alert alert-info infoMessage\">$message_info</div>";
	if($gagne) {
		echo "<div class=\"alert alert-success resultMessage\">$message_resultat</div>";
	} else {
		echo "<div class=\"alert alert-danger resultMessage\">$message_resultat</div>";
	}
}
?>
<div id="intro">
	<h3><?= $_SESSION['joueur_nom'] ?></h3>
	<h4><?= $_SESSION['joueur_argent'] ?> €</h4>
</div>
<br>
	<form method="get" action="roulette.php" id="formJeu">
	<table id="rouletteTable">

		<tr class="bborder">
			<td colspan="3"><input type="number" min="1" max="<?= $_SESSION['joueur_argent'] ?>" name="mise" placeholder="Votre mise" /></td>
		</tr>
		
		<tr class="bborder">
			<td id="textSliderNombre">Miser sur un nombre</td>
			<td>
			<!-- Rounded switch -->
			<label class="switch">
			  <input type="checkbox">
			  <span class="slider round" id="selecteurJeu"></span>
			</label> 
			</td>
			
			<td id="textSliderParite">Miser sur la parité</td>
		</tr>

		<tr class="bborder" id="trJeu">
			<td id="tdJeuNombre" colspan="3">
			<div class="blockJeu">
				Choisissez votre nombre<br><br>
				<input type="number" name="numero" min="1" max="36" />
			</div>
			</td>
			<td id="tdJeuParite" colspan="3">
			<div class="blockJeu">
				Choisissez la parité<br><br>
				
				<input id="btnRadioPair" class="checkBoxParite" name="parite" value="pair" type="radio">
				<label for="btnRadioPair" id="labelRadioPair" class="labelRadioParite">Pair</label>
				<input id="btnRadioImpair" class="checkBoxParite" name="parite" value="impair" type="radio">
				<label for="btnRadioImpair" id="labelRadioImpair" class="labelRadioParite">Impair</label>
			   
			</div>
			</td>
		</tr>

		<tr>
			<td colspan="3"><input type="submit" name="btnJouer" class="btn btn-success" value="Jouer" /></td>
		</tr>
		<tr>
			<td colspan="3"><a href="connexion.php?deco" id="quitButton" class="btn btn-danger">Quitter</a></td>
		</tr>
	</table>
	</form>
	

	<!-- Les scripts Javascript juste avant le <body> fermant -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="script.js"></script>

</body>
</html>