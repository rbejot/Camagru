<?php
	require('database.php');

	try {
		$req = new PDO("mysql:host=localhost", $DB_USER, $DB_PASSWORD);

		$req->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "DROP DATABASE camagru";
		$req->exec($sql);
		echo "DB supprimée";
	}
	catch(PDOException $e)
	{
		echo $sql . "<br />" . $e->getMessage;
	}
 ?>
