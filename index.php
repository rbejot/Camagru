<?php
	session_start();

	if ($_SESSION['pseudo'])
		$_SESSION['pseudo'] = "";
 ?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/index.css" media="screen" title="no title" charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<title>Camagru - Login</title>
	</head>
	<body>
		<div class="page">
			<div class="header">
				<h1 class="titre" style="text-align:center;color:#79D9EA;">Camagru Sunrise</h1>
			</div>
			<div class="formulaire">
					<a href="inscription.php" style="text-decoration:none;color:#4D4D4D;">s'inscrire</a><br>
					<a href="login.php" style="text-decoration:none;color:#4D4D4D;">se connecter</a>
			</div>
		</div>
	</body>
</html>
