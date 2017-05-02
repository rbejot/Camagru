<?php
session_start();
$_SESSION['loginErr'] = "";
$_SESSION['formErr'] = "";
if ($_POST['pseudo'] === "admin" && $_POST['pass'] === "admin" && $_POST['submit'] === "Confirmer")
	header('Location: ../config/setup.php');
if ($_POST['pseudo'] && $_POST['pass'] && $_POST['submit'] === "Confirmer")
{
	$pseudo = $_POST['pseudo'];
	$password = hash('whirlpool', $_POST['pass']);
	if (!ctype_alnum($pseudo) || !ctype_alnum($pseudo))
	{
		$_SESSION['loginErr'] = "Ce compte n'existe pas";
		header('Location: ../login.php');
	}
	require('connect_to_bdd.php');
	$req = $bdd->prepare("SELECT pseudo, pass FROM user WHERE pseudo = ? AND pass = ?");
	$req->execute(array($pseudo, $password));
	$donnees = $req->fetch();
	$req->closeCursor();
	if ($donnees)
	{
		$_SESSION['pseudo'] = $_POST['pseudo'];
		header('Location: ../camagru/galery.php');
	}
	else
	{
		$_SESSION['loginErr'] = "Mot de passe / Login incorrect";
		header('Location: ../login.php');
	}
}
else
{
	$_SESSION['formErr'] = "Remplissez tous les champs pour vous connecter.";
	header('Location: ../login.php');
}

 ?>
