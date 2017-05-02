<?php
	session_start();
	if (!$_SESSION['pseudo'])
        header('Location: ../index.php');
 ?>

 <html>
 	<head>
 		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<link rel="stylesheet" href="../css/index.css" media="screen" title="no title" charset="utf-8">
 		<title>Camagru - Mot de passe</title>
 	</head>
 	<body>


		<div class="page">
			<?php include('../camagru/menu.php') ?>
			<div class="formulaire" style="margin-top:200px;height:150px;width:350px;text-align:center;padding:20px;border-style:solid;	border-color:#79D9EA;">
				<form action="add_new_pass.php" method="post">
					<?php
						if ($_SESSION['passErr'])
						{
								$err = $_SESSION['passErr'];
								echo "<span style='color:red;'>$err</span><br>";
						}
						$_SESSION['passErr'] = "";
					 ?>
					Nouveau mot de passe <br>
					<input type="password" name="new_pass" value=""><br>
		 			Confirmer <br>
					<input type="password" name="confirm" value=""><br>
					<input type="submit" name="submit" value="Changer mon mot de passe">
		 		</form>
			</div>
		</div>
 	</body>
 </html>
