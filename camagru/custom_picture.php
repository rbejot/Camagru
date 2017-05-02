<?php
session_start();
$_SESSION['picture'] = "";

function display_pics($filename, $type)
{
	list($width, $height) = getimagesize($filename);
	$newwidth = 350;
	$reduction = (($newwidth * 100) / $width);
	$newheight = (($height * $reduction) / 100);
	if ($_POST['submit'])
	{
		$picturename = $_SESSION['image_name'];
		if (!$_POST['images'])
			$_POST['images'] = "angry-1";
		$thumb = imagecreatetruecolor($newwidth, $newheight);

		if ($type == 1)
			$source = imagecreatefrompng($filename);
		if ($type == 2)
			$source = imagecreatefromjpeg($filename);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		$image_source = "../images/png/".$_POST['images'].".png";
		$src = imagecreatefrompng($image_source);
		list($src2x, $src2y) = getimagesize($image_source);
		imagecopyresampled($thumb, $src, $newwidth / 4, $newheight / 4, 0, 0, $src2x - 20, $src2y - 20, $src2x, $src2y);
		if (!file_exists("../images/".$_SESSION['pseudo']))
			mkdir("../images/".$_SESSION['pseudo']);
		if ($type == 1)
		{
			$fileType = "image/png";
			$filename = "../images/".$_SESSION['pseudo']."/".$picturename;
			$_SESSION['image_size'] = array($newwidth, $newheight);
			$_SESSION['image_path'] = $filename;
			imagepng($thumb, $filename);
		}
		if ($type == 2)
		{
			$fileType = "image/jpeg";
			$filename = "../images/".$_SESSION['pseudo']."/".$picturename;
			$_SESSION['image_path'] = $filename;
			imagejpeg($thumb, $filename);
		}
		$pseudo = $_SESSION['pseudo'];
		require('../php/connect_to_bdd.php');
		$bdd->exec("INSERT INTO upload(folder, owner) VALUES('$filename', '$pseudo')");
		// header("Location: your_image.php");
		header("Location: my_pictures.php");
	}
	else
		$_SESSION['picture'] = "<div id='container'><img src='$filename' width='$newwidth' height='$newheight'/></div>";
}

if (!$_SESSION['pseudo'])
	header('Location: ../index.php');
if (!$_SESSION['image'] || !$_SESSION['image_type'])
	header('Location: upload_file.php');

$filename = $_SESSION['image'];
$filetype = $_SESSION['image_type'];

if ($filetype === "image/png")
	display_pics($filename, 1);
if ($filetype === "image/jpeg")
	display_pics($filename, 2);
 ?>

 <html>
 	<head>
 		<meta charset="utf-8">
 		<title>Camagru - Custom picture</title>
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<link rel="stylesheet" href="../css/custom_picture.css" media="screen" title="no title" charset="utf-8">
		<style media="screen">
			#fusion {
				position: absolute;
			}
			.header {
				position: relative;
			}
			.content {
				margin-top: -10px;
			}
		</style>
 	</head>
 	<body>
		<div class="page">
			<?php include('menu.php') ?>
			<div class="content">
				<div class="custom_image">
					<h1 style="margin-top:-20px;">Ton Montage photo</h1>
					<img id="fusion" src="../images/png/angry-1.png" alt="" />
					<?php
						if ($_SESSION['picture'])
							echo $_SESSION['picture'];
					 ?>
					<form action="" method="post">
						<label  for="angry-1"><img src="../images/png/angry-1.png" width="50" height="50"/></label>
						<input onclick="myFunction('1')" type="radio" name="images" value="angry-1">

						<label for="crying"><img src="../images/png/crying.png" width="50" height="50"/></label>
						<input onclick="myFunction('2')" type="radio" name="images" value="crying">

						<label for="smiling"><img src="../images/png/smiling.png" width="50" height="50"/></label>
						<input onclick="myFunction('3')" type="radio" name="images" value="smiling">

						<label for="in-love"><img src="../images/png/in-love.png" width="50" height="50"/></label>
						<input onclick="myFunction('4')" type="radio" name="images" value="in-love">

						<label for="nerd"><img src="../images/png/nerd.png" width="50" height="50"/></label>
						<input onclick="myFunction('5')" type="radio" name="images" value="nerd"><br>
						<input class="submit" type="submit" name="submit" value="Enregistrer"><br>
						<a href="upload_file.php" style="color:black;">Changer de fichier</a><br>
						<a href="webcam.php"  style="color:black;">Prendre une photo avec la webcam</a>
					</form>
				</div>
				<div class="paging">
					<div class="my_pictures" >
						<h1 style="margin-right:200px;margin-top:-20px;">Tes photos</h1><br>
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
							echo "<div class='pagination' style='margin:auto;text-align:center;'>
								<a href='custom_picture.php?page=1'>[1]</a>
								<a href='custom_picture.php?page=2'>[2]</a>
							</div>";
						}
						if ($nb_pictures == 12)
						{
							echo "<div class='pagination' style='margin:auto;text-align:center;'>
								<a href='custom_picture.php?page=3'>[3]</a>
							</div>";
						}
						if ($nb_pictures == 18)
						{
							echo "<div class='pagination' style='margin:auto;text-align:center;'>
								<a href='custom_picture.php?page=1'>[1]</a>
								<a href='custom_picture.php?page=2'>[2]</a>
								<a href='custom_picture.php?page=3'>[3]</a>
							</div>";
						}
					}
					$reponse->closeCursor();
					 ?>
				</div>
				</div>
				<?php include('footer.php'); ?>
			</div>
		</div>

		<script type="text/javascript" src="../js/image_selector.js"></script>
 	</body>
 </html>
