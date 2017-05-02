<?php
	session_start();

	$_SESSION['image'] = "";
	if (!$_SESSION['pseudo'])
		header('Location: ../index.php');

	if (isset($_POST['upload']) && $_FILES['userfile']['error'] == 1)
		$error = 2;
	if (isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
	{
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];

		list($width, $height) = getimagesize($tmpName);
		if ($width < 60 || $height < 60 || $height > 2000 || $whidth > 2000)
			$error = 4;
		$content = file_get_contents($tmpName);
		$base64 = 'data:' . $fileType . ';base64,' . base64_encode($content);
		if(!get_magic_quotes_gpc())
		{
		    $fileName = addslashes($fileName);
		}
		if (strlen($fileName) > 100)
			$error = 1;
		if ($fileType !== "image/png" && $fileType !== "image/jpeg")
			$error = 3;
		require('../php/connect_to_bdd.php');
		$check_path = "../images/".$_SESSION['pseudo']."/".$fileName;
		$req = $bdd->prepare('SELECT folder FROM upload WHERE folder = ?');
		$req->execute(array($check_path));
		$donnees = $req->fetch();
		if ($donnees)
			$error = 6;
		if (!$error)
		{
			$_SESSION['image'] = $base64;
			$_SESSION['image_type'] = $fileType;
			$_SESSION['image_name'] = $fileName;
			header('Location: custom_picture.php');
		}

	}
	if ($error == 1)
		$_SESSION['upload_error'] = "$fileName  Nom du fichier trop long<br>";
	if ($error == 2)
		$_SESSION['upload_error'] = "$fileName  Fichier trop volumineux<br>";
	if ($error == 3)
		$_SESSION['upload_error'] = "$fileName  Type de fichier invalide<br>";
	if ($error == 4)
		$_SESSION['upload_error'] =  "$fileName  Les dimensions de l'image ne conviennent pas";
	if ($error == 6)
		$_SESSION['upload_error'] =  "$fileName  Fichier existe deja";
 ?>


<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/index.css" media="screen" title="no title" charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<title>Camagru - Upload</title>
	</head>
	<body>
		<div class="page">
			<?php include('menu.php') ?>
			<div class="content" style="margin: auto;margin-top: 100px;width: 500px;height: 300px;display: flex;flex-direction: column;justify-content: center;">
				<span>Upload de fichier .png, .jpeg</span><br />
				<?php
					if ($_SESSION['upload_error'])
					{
						$error = $_SESSION['upload_error'];
						echo "<span style='color:red;'>$error</span><br />";
					}
					$_SESSION['upload_error'] = "";
				 ?>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="file" name="userfile">
					<input name="upload" type="submit" value=" Upload ">
				</form>
			</div>
			<?php include('footer.php'); ?>
		</div>
	</body>
</html>
