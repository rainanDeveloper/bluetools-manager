<?php 

include './classes/user.class.php';

session_start();

$CONFIG = json_decode(file_get_contents('./config.json'));

$link = mysqli_connect($CONFIG->host, $CONFIG->user, $CONFIG->pass, $CONFIG->base);

if (empty($_SESSION['login'])) {
	header('location: ./');
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Bluetools Manager - Recebimentos</title>
	<script src="./JS/vue.js"></script>
	<link rel="shortcut icon" href="./Media/logo.png">
	<link rel="stylesheet" type="text/css" href="CSS/general.css">
</head>
<body>
	<?php 
		include 'header.component.php'
	 ?>
	<div class="content">
		
	</div>
</body>
</html>