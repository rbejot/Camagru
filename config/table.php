<?php
	require('database.php');

	try {
		$req = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$req->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "CREATE TABLE `camagru`.`user` ( `id` INT NOT NULL AUTO_INCREMENT , `pseudo` VARCHAR(255) NOT NULL , `pass` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

		$req->exec($sql);

		$sql = "CREATE TABLE upload (
		id INT NOT NULL AUTO_INCREMENT,
		folder VARCHAR(100) NOT NULL,
		owner VARCHAR(100) NOT NULL,
		PRIMARY KEY(id)
		);";

		$req->exec($sql);

		$sql = "CREATE TABLE `camagru`.`comment` ( `id` INT NOT NULL AUTO_INCREMENT , `photo` VARCHAR(100) NOT NULL , `user` VARCHAR(100) NOT NULL , `text` VARCHAR(400) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

		$req->exec($sql);

		$sql = "CREATE TABLE `camagru`.`my_like` ( `id` INT NOT NULL AUTO_INCREMENT , `photo` VARCHAR(100) NOT NULL , `user` VARCHAR(100) NOT NULL , `text` VARCHAR(400) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

		$req->exec($sql);

		header('Location: ../index.php');
	}
	catch(PDOException $e)
	{
		echo $sql . "<br />" . $e->getMessage();
	}

	$req = null;
 ?>
