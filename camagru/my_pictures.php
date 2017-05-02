<?php
	session_start();
	if (!$_SESSION['pseudo'])
		header("Location: ../index.php");
 ?>
<html>
	<head>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<link rel="stylesheet" href="../css/custom_picture.css" media="screen" title="no title" charset="utf-8">
		<style media="screen">
		.content {
			margin: auto;
			margin-top: 200px;
			width: 700px;
			height: 500px;
			border-style:solid;
			border-color:#79D9EA;
			padding:20px;
			transition-duration:0.4s;
			display: flex;
			justify-content: center;
			flex-direction: row;
			flex-wrap: wrap;
		}

		.content div {
			margin: 10px;
		}

		.content:hover {
				box-shadow: 0px 0px 40px 30px rgba(51,77,94,0.1);
		}

		</style>
		<title>Mes photos</title>
	</head>
	<body>
		<div class="page">
				<?php include('menu.php') ?>
			<div class="content">
				<?php
					$pseudo = $_SESSION['pseudo'];
					require('../php/connect_to_bdd.php');
					$reponse = $bdd->query("SELECT * FROM upload WHERE owner='$pseudo'");
					if ($_GET['page'])
					{
						$page = $_GET['page'];
						if ($page == 1)
							$nb_pictures = 0;
						if ($page == 2)
							$nb_pictures = 5;
						if ($page == 3)
							$nb_pictures = 11;
						else
							$nb_pictures = 0;
					}
					$print = 0;
					while ($donnees = $reponse->fetch())
					{

						$path = $donnees['folder'];
						list($width, $height) = getimagesize($path);
						$newwidth = $width / 2;
						$newheight = $height / 2;
						$file_name = str_replace("../images/".$pseudo."/", "", $path);
						if ($page == 1 && $print < 5)
						{
							echo "<div><a href='picture.php?nom=$pseudo&amp;file=$file_name'><img src='$path' width='$newwidth' height='$newheight' /></a></div>";
						}
						if ($page == 2 && $print >= 5 && $print < 11)
						{
							echo "<div><a href='picture.php?nom=$pseudo&amp;file=$file_name'><img src='$path' width='$newwidth' height='$newheight' /></a></div>";
						}
						if ($page == 3 && $print >= 11 && $print < 17)
						{
							echo "<div><a href='picture.php?nom=$pseudo&amp;file=$file_name'><img src='$path' width='$newwidth' height='$newheight' /></a></div>";
						}
						if (!$page && $print < 5)
						{
							echo "<div><a href='picture.php?nom=$pseudo&amp;file=$file_name'><img src='$path' width='$newwidth' height='$newheight' /></a></div>";
						}
						$print++;
					}
					$reponse->closeCursor();
				?>
			</div>
			<?php
			$pseudo = $_SESSION['pseudo'];
			require('../php/connect_to_bdd.php');
			$reponse = $bdd->query("SELECT * FROM upload WHERE owner='$pseudo'");
			if ($_GET['page'])
			{
				$page = $_GET['page'];
				if ($page == 1)
					$nb_pictures = 0;
				if ($page == 2)
					$nb_pictures = 5;
				if ($page == 3)
					$nb_pictures = 11;
				else
					$nb_pictures = 0;
			}
			while ($donnees = $reponse->fetch())
			{
				$nb_pictures++;
				if ($nb_pictures == 6)
				{
					echo "<div class='pagination' style='margin:auto;'>
						<a href='my_pictures.php?page=1'>[1]</a>
						<a href='my_pictures.php?page=2'>[2]</a>
					</div>";
				}
				if ($nb_pictures == 12)
				{
					echo "<div class='pagination' style='margin:auto;'>
						<a href='my_pictures.php?page=3'>[3]</a>
					</div>";
				}
				if ($nb_pictures == 18)
				{
					echo "<div class='pagination' style='margin:auto;'>
						<a href='my_pictures.php?page=1'>[1]</a>
						<a href='my_pictures.php?page=2'>[2]</a>
						<a href='my_pictures.php?page=3'>[3]</a>
					</div>";
				}
			}
			$reponse->closeCursor();
			 ?>
			 <?php include('footer.php'); ?>
		</div>
	</body>
</html>
