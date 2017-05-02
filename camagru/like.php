<?php
	session_start();

	if (!$_SESSION['pseudo'])
		header("Location: ../index.php");

	if ($_GET['picture'])
	{
		$path = $_GET['picture'];
		$pseudo = $_SESSION['pseudo'];
		$comment = "1";
		require('../php/connect_to_bdd.php');
		$req = $bdd->prepare("SELECT text FROM my_like WHERE photo = ?");
		$req->execute(array($path));
		$data = $req->fetch();
		if (!$data)
		{
			header('Location: galery.php');
		}
		$req->closeCursor();
		$req = $bdd->query("SELECT text FROM my_like WHERE user='$pseudo' AND photo='$path'");
		while ($donnees = $req->fetch())
		{
			$number = $donnees['text'];
			if ($number === "1")
				$bdd->exec("DELETE FROM my_like WHERE user='$pseudo' AND photo='$path'");
		}
		$req->closeCursor();
		if (!$number)
		{
			$bdd->exec("INSERT INTO my_like(photo, user, text) VALUES('$path', '$pseudo', '$comment')");
		}
	}
	header('Location: galery.php');
 ?>
