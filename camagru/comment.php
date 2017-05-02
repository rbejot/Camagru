<?php
	session_start();

	if (!$_SESSION['pseudo'])
		header('Location: ../index.php');
	if (!$_GET['picture'] || !$_GET['owner'])
		header('Location: galery.php');
	if ($_GET['picture'] && $_GET['owner'])
	{
		require('../php/connect_to_bdd.php');
		$picture = $_GET['picture'];
		$owner = $_GET['owner'];
		$req = $bdd->prepare('SELECT folder FROM upload WHERE pseudo = ?');
		$req->execute(array($owner));
		$donnees = $req->fetch();
		if ($donnees)
			$no_error = 1;
		else
			header('Location: galery.php');
		$req->closeCursor();

		$reponse = $bdd->prepare('SELECT folder FROM upload WHERE folder = ?');
		$reponse->execute(array($picture));
		$data = $reponse->fetch();
		if ($data)
			$no_error = 2;
		else
			header('Location: galery.php');
		$reponse->closeCursor();
	}
	if ($_POST['commentaire'] !== "" && $_POST['submit'])
	{
		$comment = $_POST['commentaire'];
		$pseudo = $_SESSION['pseudo'];
		$path = $_GET['picture'];
		if (strlen($comment) >= 70)
		{
			$_SESSION['erreur_comment'] = "Ton commentaire est trop long";
			header("Refresh:0");
		}
		if ($comment[0] === " ")
		{
			header("Refresh:0");
		}
		else
		{
			require('../php/connect_to_bdd.php');
			$req = $bdd->prepare("INSERT INTO comment(photo, user, text) VALUES( ?, ?, ?)");
			$req->execute(array($path, $pseudo, $comment));

			if ($_GET['owner'])
			{
				$owner = $_GET['owner'];
				$reponse = $bdd->query("SELECT email FROM user WHERE pseudo='$owner'");
				while ($donnees = $reponse->fetch())
				{
					$email = $donnees['email'];
					$message = "Quelqu'un a mis un commentaire sur ta photo !";
					mail($email, 'Tu as un nouveau commentaire', $message);
				}
				$reponse->closeCursor();
			}
			header("Refresh:0");
		}
	}
 ?>

 <html>
 	<head>
 		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<link rel="stylesheet" href="../css/index.css" media="screen" title="no title" charset="utf-8">
 		<title>Camagru - Comment</title>
		<style media="screen">
			.content {
				margin: auto;
				margin-top: 200px;
			}
			.comment_block {
				width: 300px;
				height: 50px;
				background-color: white;
				margin: 5px;
				border-style: solid;
				border-color: #79D9EA;
			}
			.comment_text {
				font-size: 10px;
			}
		</style>
 	</head>
 	<body>
 		<div class="page">
 			<?php include('../camagru/menu.php') ?>
 			<div class="content">
				<div class="photo">
					<?php
						if ($_GET['picture'])
						{
							$path = $_GET['picture'];
							list($width, $height) = getimagesize($path);
							echo "<img src='$path' width='$width' height='$height'/>";
						}
					 ?>
				</div>
					<?php
						require('../php/connect_to_bdd.php');
						$path = $_GET['picture'];
						$reponse = $bdd->query("SELECT * FROM comment WHERE photo='$path'");
						while ($donnees = $reponse->fetch()): ?>
							<div class='comment_block'>
							<span class='comment_user'><?= $donnees['user'] ?></span><br />
							<span class='comment_text'><?= htmlentities($donnees['text']) ?></span>
							</div>
						<?php endwhile;
						$reponse->closeCursor();
					?>
				<div class="form">
					<form class="" action="" method="post">
						<input class='text' type="textarea" name="commentaire" value=""><br>
						<input type="submit" name="submit" value="Commenter">
					</form>
				</div>
 			</div>
 		</div>
 	</body>
 </html>
