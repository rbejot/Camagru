<?php
	session_start();
	$pseudo = $_SESSION['pseudo'];
	if (is_dir("../images/".$pseudo))
	{
		array_map('unlink', glob("../images/".$pseudo."/*"));
		rmdir("../images/".$pseudo);
	}
	$_SESSION['pseudo'] = "";
	require('connect_to_bdd.php');
	$bdd->exec("DELETE FROM user WHERE pseudo='$pseudo'");
	$bdd->exec("DELETE FROM upload WHERE owner='$pseudo'");
	header('Location: ../index.php');
 ?>
