<?php
	session_start();
	if ($_POST['image'])
	{
		$_SESSION['image'] = $_POST['image'];
		$_SESSION['image_type'] = "image/jpeg";
		$_SESSION['image_name'] = time();
	}
	else
		header('Location: galery.php');
 ?>
