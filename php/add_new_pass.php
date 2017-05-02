<?php
session_start();
if (!$_SESSION['pseudo'])
	header('Location: ../index.php');
$_SESSION['passErr'] = "";

function send_mail($pseudo, $email) {
	$message = "Bonjour ".$pseudo.", on te confirme le changement de ton mot de passe.";
	mail($email, 'Changement de mot de passe', $message);
}

if ($_POST['confirm'] && $_POST['new_pass'] && $_POST['submit'] === "Changer mon mot de passe")
{
	if (!ctype_alnum($_POST['confirm']) || !ctype_alnum($_POST['new_pass']))
	{
		$_SESSION['passErr'] = "Mauvais mot de passe (caractères alphanumériques seulement)";
		header('Location: change_pass.php');
	}
	if ($_POST['confirm'] !== $_POST['new_pass'])
	{
		$_SESSION['passErr'] = "Erreur de saisi dans la confirmation de ton mot de passe";
		header('Location: change_pass.php');
	}
	else
	{
		$password = hash('whirlpool', $_POST['new_pass']);
		$pseudo = $_SESSION['pseudo'];
		require('connect_to_bdd.php');
		$bdd->exec("UPDATE user SET pass = '$password' WHERE pseudo = '$pseudo'");
			$reponse = $bdd->query("SELECT email FROM user WHERE pseudo = '$pseudo'");
		while ($donnees = $reponse->fetch())
			$email = $donnees['email'];
		$reponse->closeCursor;
		send_mail($pseudo, $email);
		header('Location: ../camagru/galery.php');
	}
}
else {
	$_SESSION['passErr'] = "Tous les champs doivent être remplis";
	header('Location: change_pass.php');
}
 ?>
