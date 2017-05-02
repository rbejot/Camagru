<?php
	session_start();
 ?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/index.css" media="screen" title="no title" charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<title>Camagru - inscription</title>
	</head>
	<body>
		<div class="page">
			<div class="header">
				<h1 class="titre" style="text-align:center;color:#79D9EA;">Camagru Sunrise</h1>
			</div>
			<div class="formulaire" style="width:70%;height:300px;">
				<form  action="php/check_register.php"  method="post">
					<?php
						if ($_SESSION['pseudoErr'])
							echo $_SESSION['pseudoErr'] . " " ."<br>";
						else
							echo "Pseudo "."<br>";
					?>
					<input type="text" name="pseudo" value="" required><br>
					<?php
						if ($_SESSION['emailErr'])
							echo $_SESSION['emailErr'] . " "."<br>";
						else
							echo "Email "."<br>";
					?>
					<input type="text" name="email" value="" required><br>
					<?php
						if ($_SESSION['passErr'])
							echo $_SESSION['passErr'] . " "."<br>";
						else
							echo "Mot de passe "."<br>";
					 ?>
					<input type="password" name="pass" value="" required><br>
					<?php
						if ($_SESSION['confirmErr'])
							echo $_SESSION['confirmErr'] . " "."<br>";
						else
							echo "Confirme ton mot de passe "."<br>";
					 ?>
					<input type="password" name="pass_confirm" value="" required><br>
					<?php
						if ($_SESSION['formErr'])
							echo $_SESSION['formErr'] . " "."<br>";
						session_destroy();
					 ?>
					<input class="submit" type="submit" name="submit" value="valider"><br>
					<a href="login.php">déjà un compte ?</a>
				</form>
			</div>
		</div>

	</body>
</html>
