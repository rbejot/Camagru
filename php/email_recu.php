<?php
	session_start();
	if (!$_SESSION['email'])
		header('Location: ../index.php');
	else
		$_SESSION['email'] = "";
 ?>

<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<link rel="stylesheet" href="../css/index.css" media="screen" title="no title">
		<title>Réinitialisation de mot de passe</title>
	</head>
	<body>
		<p>
			Tu as reçu un nouveau mot de passe à l'adresse mail lié à ton compte. Vérifie tes courriers indésirables.
		</p>
		<a href="../login.php">Connecte toi avec ton nouveau mot de passe !</a>
	</body>
</html>
