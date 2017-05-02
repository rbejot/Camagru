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
		<title>Camagru</title>
	</head>
	<body>
		<div class="page">
			<?php include('menu.php'); ?>
			<div class="content" style="margin: auto;margin-top: 100px;width: 500px;height: 300px;display: flex;flex-direction: row;justify-content: center;">
				<div class="choice">
					<a href="webcam.php"><img src="../images/webcam.png" alt="" width="150">
					</a>
				</div>
				<div class="choice">
					<a href="upload_file.php"><img src="../images/cloud-computing.png" alt="" width="150">
					</a>
				</div>
			</div>
			<?php include('footer.php'); ?>
		</div>
	</body>
</html>
