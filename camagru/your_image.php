<?php
	session_start();
	if (!$_SESSION['pseudo'] || !$_SESSION['image_path'])
		header('Location: ../index.php');
 ?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/pictures.css" media="screen" title="no title" charset="utf-8">
 		<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
		<title>Ton image</title>
	</head>
	<body>
		<div class="page">
 			<div class="header">
 				<h1>Camagru</h1>
 				<a class="home" href="galery.php"><img src="../images/home.png" alt="" /></a>
 				<a href="take_picture.php">Prendre photo</a>
 				<a href="my_pictures.php">Mes photos</a>
 				<a href="../my_account.php">Mon compte</a>
 				<a href="../php/logout.php">Me déconnecter</a>
 			</div>
			<div class="content">
				<div class="image">
					<h1>Ton montage</h1>
					<?php
						$path = $_SESSION['image_path'];
						$pseudo = $_SESSION['pseudo'];
						list($width, $height) = getimagesize($path);
						echo "<img src='$path' alt='' height='$height' width='$width'/>";
						echo "<div>
						<a href='delete_picture.php?pseudo=$pseudo&amp;file=$path'>Supprimer ta photo</a></div>";
					?>
					 <div class="">
					 	<a href="take_picture.php">Upload un autre fichier</a><br><br>
						<a href="webcam.php">Webcam</a>
					 </div>
				</div>
				<div class="my_pictures">
					<h1 >Tes photos</h1>
					<?php
						$pseudo = $_SESSION['pseudo'];
						require('../php/connect_to_bdd.php');
						$reponse = $bdd->query("SELECT * FROM upload WHERE owner='$pseudo'");
						while ($donnees = $reponse->fetch())
						{
							$path = $donnees['folder'];
							list($width, $height) = getimagesize($path);
							$newwidth = $width / 2;
							$newheight = $height / 2;
							$file_name = str_replace("../images/".$pseudo."/", "", $path);
							echo "<div><a href='picture.php?nom=$pseudo&amp;file=$file_name'><img src='$path' width='$newwidth' height='$newheight' /></a></div>";
						}
						$reponse->closeCursor();
					?>
				</div>
			</div>
 		</div>
	</body>
</html>
