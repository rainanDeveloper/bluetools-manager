<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './classes/user.class.php';

session_start();

$CONFIG = json_decode(file_get_contents('./config.json'));

$link = mysqli_connect($CONFIG->host, $CONFIG->user, $CONFIG->pass, $CONFIG->base);
mysqli_set_charset($link, 'utf-8');


 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Bluetools Manager - <?php echo (!empty($_GET['id'])?'Edição de conta a receber':'Nova conta a receber'); ?></title>
 </head>
 <body>
 
 </body>
 </html>