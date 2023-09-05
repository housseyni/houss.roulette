<?php
require_once('BDD_Manager.php');

$message_erreur = '';

// Vérifie que le bouton du formulaire a été cliqué
if(isset($_GET['btnConnect'])) {
	// Vérifie que les champs existent et ne sont pas vides
	if(isset($_GET['nom']) && $_GET['nom'] != '' &&
		isset($_GET['motdepasse']) && $_GET['motdepasse'] != '') {
		$message_erreur = connecteUtilisateur($_GET['nom'], $_GET['motdepasse']);
		if($message_erreur == '') {
			// Si pas d'erreur, renvoie l'utilisateur vers le jeu de la roulette
			header('Location: roulette.php');
		}
	}
}
	
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Connexion</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<header id="head">
	<h2 class="alert alert-warning">Connexion</h2>
</header>
<br>
<?php if($message_erreur != '')
	echo "<div class=\"alert alert-danger errorMessage\">$message_erreur</div>";
?>

<form method="get" action="connexion.php">
	<table id="connexionTable">
		<tr>
			<td colspan="3"><input type="text" name="nom" placeholder="Identifiant" /></td>
		</tr>

		<tr>
			<td colspan="3"><input type="text" name="motdepasse" placeholder="Mot de passe" /></td>
		</tr>

		<tr>
			<td><br><a href="#"><input class="btn btn-warning" name="btnErase" type="reset" value="Effacer" /></a></td>
			<td><br><a href="inscription.php"><div class="btn btn-info">S'inscrire</div></a></td>
			<td><br><input class="btn btn-primary" name="btnConnect" type="submit" value="Jouer" /></td>
		</tr> 
	</table>
</form>
<br><br>



</body>
</html>