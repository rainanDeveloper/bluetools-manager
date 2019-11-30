<?php 

include './classes/user.class.php';

session_start();

$CONFIG = json_decode(file_get_contents('./config.json'));

$link = mysqli_connect($CONFIG->host, $CONFIG->user, $CONFIG->pass, $CONFIG->base);

if (empty($_SESSION['login'])) {
	header('location: ./');
}

if (isset($_GET['sair'])) {
	session_destroy();
	header('location: ./');
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Bluetools Manager</title>
	<script src="./JS/vue.js"></script>
	<link rel="shortcut icon" href="./Media/logo.png">
	<link rel="stylesheet" type="text/css" href="CSS/general.css">
	<link rel="stylesheet" type="text/css" href="CSS/painel.css">
</head>
<body>
	<?php 
		include 'header.component.php'
	 ?>
	 <div class="content">
	 	<div class="painel">
	 		<h1 class="panelTitle">Painel de avisos</h1>
	 		<div class="card recebimento">
	 			<div class="cardContent"><div class="indicator"><?php echo number_format(rand(100, 999999)/100, 2, ',', ''); ?></div></div>
	 			<h2 class="cardTitle">Recebimentos</h2>
	 		</div>
	 		<div class="card pagamentos">
	 			<div class="cardContent"><div class="indicator"><?php echo number_format(rand(100, 999999)/100, 2, ',', ''); ?></div></div>
	 			<h2 class="cardTitle">Pagamentos</h2>
	 		</div>
	 		<div class="card contrato">
	 			<div class="cardContent"><div class="indicator"><?php echo number_format(rand(100, 999999)/100, 2, ',', ''); ?></div></div>
	 			<h2 class="cardTitle">Contratos novos</h2>
	 		</div>
	 		<div class="card fat-chart card-double-sized">
	 			<div class="cardContent"><div class="card-chart" style="width: 100%; height: 250px;"></div></div>
	 			<h2 class="cardTitle">Faturamento</h2>
	 		</div>
	 		<div class="card faturado">
	 			<div class="cardContent"><div class="indicator"><?php echo number_format(rand(100, 999999)/100, 2, ',', ''); ?></div></div>
	 			<h2 class="cardTitle">Total faturado</h2>
	 		</div>
	 	</div>
	 </div>
</body>
</html>