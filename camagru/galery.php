<?php
	session_start();

	if (!$_SESSION['pseudo'])
		header('Location: ../index.php');
 ?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/index.css" media="screen" title="no title" charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<title>Camagru - galerie</title>
	</head>
	<body>
		<div class="page">
			<?php include('menu.php') ?>
			<div class="content" style="margin-top:200px;display:flex;flex-direction:row;flex-wrap:wrap;">
				<?php
					$pseudo = $_SESSION['pseudo'];
					require('../php/connect_to_bdd.php');
					$reponse = $bdd->query("SELECT * FROM upload ORDER BY id DESC");
					while ($donnees = $reponse->fetch())
					{
						$path = $donnees['folder'];
						list($width, $height) = getimagesize($path);
						$newwidth = $width;
						$newheight = $height;
						$owner = $donnees['owner'];
						$border_width = $newwidth + 30;
						$border_height = $newheight + 30;
						$file_name = str_replace("../images/".$pseudo."/", "", $path);

						$req = $bdd->query("SELECT text FROM my_like WHERE user='$pseudo' AND photo='$path'");
						while ($donnees = $req->fetch())
						{
							$number = $donnees['text'];
							if ($number === "1")
							{
								$src = "../images/like.png";
							}
						}
						$req->closeCursor();
						if (!$number)
						{
							$src = "../images/unlike.png";
						}
						unset($number);
						echo "<div class='back' width='$border_width' height='$border_height' style='background-color: white;padding:20px;border-color:#79D9EA;border-style:solid;box-shadow: 0px 0px 40px 0px white;margin:50px;'><span class='owner' style='margin-right:20px;'><img class='user' src='../images/user.png' height='15' width='15'/>$owner</span><img src='$path' width='$newwidth' height='$newheight' /><a href='comment.php?picture=$path&owner=$owner'><br /><img src='../images/comment.png' height='25' width='25'/></a><a href='like.php?picture=$path' style='margin:auto;margin-top:-47px;'><img src='$src' height='25' width='25'style='margin-left:20px;'/></a><span style='text-align:center;'></span></div>";
					}
					$reponse->closeCursor();
				?>
			</div>
			<?php include('footer.php'); ?>
		</div>
	</body>
</html>
