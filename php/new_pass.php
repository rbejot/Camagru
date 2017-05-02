<?php
	session_start();
	function send_mail($pseudo, $email, $new_password) {
		$message = "Voilà ton nouveau mot de passe te permettant d'accèder à ton compte. Change le à ta première connection : ".$new_password;
		mail($email, 'Ton nouveau mot de passe', $message);
	}
	if ($_POST['pseudo'] && $_POST['submit'])
	{
		$pseudo = htmlspecialchars($_POST['pseudo']);
		require('connect_to_bdd.php');
		$req = $bdd->prepare('SELECT pseudo FROM user WHERE pseudo = ?');
		$req->execute(array($pseudo));
		$donnees = $req->fetch();
		if ($donnees)
		{
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		    $pass = array();
		    $alphaLength = strlen($alphabet) - 1;
		    for ($i = 0; $i < 8; $i++) {
		        $n = rand(0, $alphaLength);
		        $pass[] = $alphabet[$n];
		    }
			$new_password = implode($pass);
		}
		else
		{
			$_SESSION['pseudo_err'] = "Ce compte n'existe pas"."<br>";
			header('Location: ../forget_pass.php');
		}
		$req->closeCursor();
		if ($new_password)
		{
			require('connect_to_bdd.php');
			$hash_pass = hash('whirlpool', $new_password);
			$bdd->exec("UPDATE user SET pass = '$hash_pass' WHERE pseudo = '$pseudo'");
			$reponse = $bdd->query("SELECT email FROM user WHERE pseudo = '$pseudo'");
			while ($donnees = $reponse->fetch())
			{
				$email = $donnees['email'];
			}
			$reponse->closeCursor();
			send_mail($pseudo, $email, $new_password);
			$_SESSION['email'] = "Vérifie ta boîte mail";
			header('Location: email_recu.php');
		}
	}
	else
		header('Location: ../forget_pass.php');
 ?>
