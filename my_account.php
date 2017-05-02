<?php
    session_start();
    if (!$_SESSION['pseudo'])
        header('Location: index.php');
 ?>

 <html>
 	<head>
 		<meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css" media="screen" title="no title" charset="utf-8">
 		<title>Camagru - Mon compte</title>
 	</head>
 	<body>
        <div class="page">
		      <?php include('camagru/menu.php') ?>
			<div class="content" style="margin-top:200px;">
                <?php
                    $pseudo = $_SESSION['pseudo'];
                    echo "<h1>Coucou, $pseudo.</h1>";
                 ?>
                <a href="php/change_pass.php">Changer mon mot de passe</a><br>
        		<a href="php/delete_account.php">Supprimer mon compte</a>
			</div>
      <?php include('camagru/footer.php'); ?>
		</div>
 	</body>
 </html>
