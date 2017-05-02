<?php
	session_start();

	if (!$_SESSION['pseudo'])
		header('Location: ../index.php');
	if (!$_GET['pseudo'] || !$_GET['file'])
		header('Location: galery.php');
	if ($_GET['pseudo'] && $_GET['file'])
	{
		if ($_SESSION['pseudo'] !== $_GET['pseudo'])
			header('Location: galery.php');

		$folder = "../images/". $_SESSION['pseudo']. "/" . $_GET['file'];
		require('../php/connect_to_bdd.php');
		$req = $bdd->prepare("DELETE FROM upload WHERE folder= ?");
		$req->execute(array($folder));
		header('Location: my_pictures.php');
	}
 ?>
