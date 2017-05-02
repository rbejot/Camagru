<?php
	session_start();

	$_SESSION['pseudoErr'] = "";
	$_SESSION['emailErr'] = "";
	$_SESSION['confirmErr'] = "";
	$_SESSION['passErr'] = "";
	$_SESSION['formErr'] = "";

	function send_email($pseudo, $email) {
		$message = "Bienvenue sur Camagru ".$pseudo." !";
		mail($email, "inscription Camagru", $message);
	}

	function pseudo_taken($pseudo) {
		require('connect_to_bdd.php');
		$req = $bdd->prepare('SELECT pseudo FROM user WHERE pseudo = ?');
		$req->execute(array($pseudo));
		$donnees = $req->fetch();
		if ($donnees)
			$_SESSION['pseudoErr'] = "Pseudo déjà pris";
		else
			$_SESSION['pseudo'] = $pseudo;
	}

	function check_pseudo($pseudo) {
		if (strlen($pseudo) > 16)
			$_SESSION['pseudoErr'] = "Pseudo trop long";
		else if (!ctype_alnum($pseudo))
			$_SESSION['pseudoErr'] = "Ton pseudo ne doit contenir que des caractères alphanumériques";
		else
			pseudo_taken($pseudo);
	}

	function email_taken($email) {
		require('connect_to_bdd.php');
		$req = $bdd->prepare('SELECT email FROM user WHERE email = ?');
		$req->execute(array($email));
		$donnees = $req->fetch();
		if ($donnees)
			$_SESSION['emailErr'] = "Email déjà pris";
		else
			$_SESSION['email'] = $email;
	}

	function check_email($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			$_SESSION['emailErr'] = "Email invalide";
		else
			email_taken($email);
	}
	function add_pass($pass) {

	}
	function check_password($pass, $pass_confirm) {
		if ($pass !== $pass_confirm)
			$_SESSION['confirmErr'] = "Tu as fait une erreur en confirmant ton mot de passe";
		if (!ctype_alnum($pass))
			$_SESSION['passErr'] = "Ton mot de passe ne doit contenir que des caractères alphanumériques";
		if ($pass === $pass_confirm)
			$_SESSION['pass'] = hash('whirlpool', $pass);
	}
	function form_verify($pseudo, $email, $pass, $pass_confirm){
		check_pseudo($pseudo);
		check_email($email);
		check_password($pass, $pass_confirm);
	}
	if ($_POST['pseudo'] && $_POST['email'] && $_POST['pass'] && $_POST['pass_confirm'] && $_POST['submit'] === "valider")
	{
		form_verify($_POST['pseudo'], $_POST['email'], $_POST['pass'], $_POST['pass_confirm']);

		if ($_SESSION['pseudo'] && $_SESSION['email'] && $_SESSION['pass'])
		{
			$pseudo = $_SESSION['pseudo'];
			$email = $_SESSION['email'];
			$pass = $_SESSION['pass'];
			send_email($pseudo, $email);
			$_SESSION['email'] = "";
			$_SESSION['pass'] = "";
			$_SESSION['pseudo'] = $pseudo;
			require('connect_to_bdd.php');
			$bdd->exec("INSERT INTO user(pseudo, email, pass) VALUES('$pseudo', '$email', '$pass')");
			header('Location: ../camagru/galery.php');
		}
	}
	else
		$_SESSION['formErr'] = "Tous les champs doivent être remplis";

	if ($_SESSION['pseudoErr'] || $_SESSION['emailErr'] || $_SESSION['confirmErr']	|| $_SESSION['passErr'] || $_SESSION['formErr'])
		header('Location: ../inscription.php');
 ?>
