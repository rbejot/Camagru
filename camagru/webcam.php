<?php
	session_start();

	if (!$_SESSION['pseudo'])
		header("Location: ../index.php");
 ?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/index.css" media="screen" title="no title" charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Contrail+One" rel="stylesheet">
		<title>Camagru - Webcam</title>
	</head>
	<body>
		<div class="page">
			<?php include('menu.php') ?>
			<div class="content" style="margin: auto;margin-top: 100px;width: 500px;height: 300px;display: flex;flex-direction: column;justify-content: center;">
				<div style="margin-top:200px;">
					<video id="video" style="margin-left:30px;"></video>
					<button id="startbutton" style="margin-top:20px;margin-left:30px;width:450px;">Prendre une photo</button>
					<canvas id="canvas" style="display:none"></canvas>
				</div>

			</div>
			<?php include('footer.php'); ?>
		</div>

		<script>
		(function() {
			function getXMLHttpRequest() {
				var xhr = null;

				if (window.XMLHttpRequest || window.ActiveXObject) {
					if (window.ActiveXObject) {
						try {
							xhr = new ActiveXObject("Msxml2.XMLHTTP");
						} catch(e) {
							xhr = new ActiveXObject("Microsoft.XMLHTTP");
						}
					} else {
						xhr = new XMLHttpRequest();
					}
				} else {
					alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
					return null;
				}

				return xhr;
			}
			var streaming = false,
			  video        = document.querySelector('#video'),
			  cover        = document.querySelector('#cover'),
			  canvas       = document.querySelector('#canvas'),
			  photo        = document.querySelector('#photo'),
			  startbutton  = document.querySelector('#startbutton'),
			  width = 450,
			  height = 0;

			navigator.getMedia = ( navigator.getUserMedia ||
								 navigator.webkitGetUserMedia ||
								 navigator.mozGetUserMedia ||
								 navigator.msGetUserMedia);

			navigator.getMedia(
			{
			  video: true,
			  audio: false
			},
			function(stream) {
			  if (navigator.mozGetUserMedia) {
				video.mozSrcObject = stream;
			  } else {
				var vendorURL = window.URL || window.webkitURL;
				video.src = vendorURL.createObjectURL(stream);
			  }
			  video.play();
			},
			function(err) {
			  console.log("An error occured! " + err);
			}
			);

			video.addEventListener('canplay', function(ev){
			if (!streaming) {
			  height = video.videoHeight / (video.videoWidth/width);
			  video.setAttribute('width', width);
			  video.setAttribute('height', height);
			  canvas.setAttribute('width', width);
			  canvas.setAttribute('height', height);
			  streaming = true;
			}
			}, false);

			function takepicture() {
				var xhr = getXMLHttpRequest();
				var canvas = document.getElementById("canvas");
				canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
				var dataURL = canvas.toDataURL("image/jpeg");
				xhr.open("POST", "webcam_file.php", true);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send("image=" + encodeURIComponent(dataURL));
				document.location.href="custom_picture.php";
			   };

			startbutton.addEventListener('click', function(ev){
			  takepicture();
			ev.preventDefault();
			}, false);

			})();
		</script>
	</body>
</html>
