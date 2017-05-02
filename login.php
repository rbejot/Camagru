<?php
	session_start();
 ?>

 <html>
 	<head>
 		<meta charset="utf-8">
		<link rel="stylesheet" href="css/index.css" media="screen" title="no title" charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
 		<title>Camagru - login</title>
 	</head>
 	<body >
		<div class="page">
			<div class="header">
				<h1 class="titre" style="text-align:center;color:#79D9EA;">Camagru Sunrise</h1>
			</div>
			<div class="formulaire" style="width:70%;height:300px;">
				<form action="php/check_login.php" method="post">
					<?php
						if ($_SESSION['loginErr'])
							echo $_SESSION['loginErr']."<br />";
					 ?>
		 			Pseudo <br><input type="text" name="pseudo" value=""><br>
					Mot de passe <br><input type="password" name="pass" value=""><br>
					<?php
						if ($_SESSION['formErr'])
							echo $_SESSION['formErr'] . " "."<br>";
						session_destroy();
					 ?>
					<input type="submit" name="submit" value="Confirmer"><br>
					<a href="inscription.php">pas de compte ?</a><br>
					<a href="forget_pass.php">mot de passe oublié ?</a>
		 		</form>
			</div>
		</div>

 	</body>
 </html>
