<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './classes/user.class.php';

session_start();

$CONFIG = json_decode(file_get_contents('./config.json'));

$link = mysqli_connect($CONFIG->host, $CONFIG->user, $CONFIG->pass, $CONFIG->base);
mysqli_set_charset($link, 'utf-8');
if (mysqli_connect_errno()) {
    printf("Conexão com o mysql falhou: %s\n", mysqli_connect_error());
    exit();
}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Bluetools Manager - <?php echo (!empty($_GET['id'])?"Edição de conta a receber":"Nova conta a receber"); ?></title>
 	<meta charset="utf-8">
	<script src="./JS/vue.js"></script>
	<link rel="shortcut icon" href="./Media/logo.png">
	<link rel="stylesheet" type="text/css" href="./font-awesome/css/all.css">
	<link rel="stylesheet" type="text/css" href="CSS/general.css">
	<link rel="stylesheet" type="text/css" href="CSS/receber.css">
 </head>
 <body>
 	<div class="containerReceberBill">
 		<div class="container">
 			<form id="formAddOrUpdateBill" onsubmit="event.preventDefault()">
 				<input type="text" name="id" id="id" disabled="true" value="<?php echo(!empty($_GET['id'])?$_GET['id']:'') ?>">
 			</form>
 		</div>
 	</div>

 	<script type="text/javascript">
 		let formAddOrUpdateBill = new Vue({
			el: 'form#formAddOrUpdateBill',
			data(){
				return{

				}
			},
			methods: {
				submitForm: ()=>{
					document.querySelector('form#formAddOrUpdateBill').submit()
				}
			}
		})
 	</script>

 </body>
 </html>