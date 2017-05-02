<?php
	session_start();
	if (!$_SESSION['pseudo'])
		header('Location: ../index.php');
	if (!$_GET['nom'] || !$_GET['file'])
		header('Location: galery.php');
	if ($_GET['nom'] && $_GET['nom'] !== $_SESSION['pseudo'])
		header('Location: galery.php');
	if ($_GET['file'] && $_GET['nom'])
	{
		require('../php/connect_to_bdd.php');
		$path = "../images/".$_GET['nom']."/". $_GET['file'];
		$reponse = $bdd->prepare('SELECT folder FROM upload WHERE folder = ?');
		$reponse->execute(array($path));
		$data = $reponse->fetch();
		if ($data)
			$no_error = 2;
		else
			header('Location: galery.php');
		$reponse->closeCursor();
	}
 ?>

 <html>
 	<head>
 		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/index.css" media="screen" title="no title" charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
 		<title>Mes photos</title>
 	</head>
 	<body>
 		<div class="page">
 			<?php include('menu.php') ?>
			<div class="content" style="text-align:center;margin:auto;margin-top:200px;width:400px;height:500px;padding:20px;border-style:solid;border-color:#79D9EA;">
				<div class="image">
					<?php
					if ($_GET['nom'] && $_GET['file'])
					{
						$path = "../images/".$_GET['nom']."/". $_GET['file'];
						$img = $_GET['file'];
						list($width, $height) = getimagesize($path);
						echo "<div></sic><img src='$path' width='$width' height='$height'/></div>";
						if ($_GET['nom'] == $_SESSION['pseudo'])
						{
							$pseudo = $_SESSION['pseudo'];
							echo "<div><a href='delete_picture.php?pseudo=$pseudo&amp;file=$img'>Supprimer ta photo ?</a></div>";
						}
					}
					 ?>
					 <div class="">
					 	<a href="take_picture.php">Upload un autre fichier</a>
					 </div>
				</div>
			</div>
			<?php include('footer.php'); ?>
 		</div>
 	</body>
 </html>
