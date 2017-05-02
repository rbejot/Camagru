<?php
	session_start();
 ?>

 <html>
 	<head>
 		<meta charset="utf-8">
		<link rel="stylesheet" href="css/index.css" media="screen" title="no title" charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
 		<title>Mot de passe oublié</title>
 	</head>
 	<body>
		<div class="page">
			<div class="header">
				<h1 class="titre" style="text-align:center;color:#79D9EA;">Camagru Sunrise</h1>
			</div>
			<div class="formulaire" style="width:70%;height:150px;">
				<form action="php/new_pass.php" method="post">
					<?php
						if ($_SESSION['pseudo_err'])
						{
							$error = $_SESSION['pseudo_err'];
							echo $error;
						}
						session_destroy();
					 ?>
		 			Renseigne ton pseudo <br><input type="text" name="pseudo" value=""><br>
					<input type="submit" name="submit" value="Réinitialiser mot de passe"><br>
		 		</form>
				<a href="login.php">"Ah c'est bon je m'en souviens !"</a>
				<a href="https://www.google.fr/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=alzheimer">J'oublie souvent des trucs...</a>
			</div>
		</div>
 	</body>
 </html>
