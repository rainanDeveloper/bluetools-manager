<?php 
include './classes/user.class.php';

session_start();

$CONFIG = json_decode(file_get_contents('./config.json'));

$link = mysqli_connect($CONFIG->host, $CONFIG->user, $CONFIG->pass, $CONFIG->base);
mysqli_set_charset($link, 'utf-8');
if (!empty($_POST)) {
	$user = new User(utf8_encode($_POST['inputLogin']), utf8_encode($_POST['inputSenha']));

	if ($user->validateUser($link)) {
		$_SESSION['login'] = $_POST['inputLogin'];
		$_SESSION['senha'] = $_POST['inputSenha'];

		header('location: ./home.php');
	}
}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="./Media/logo.png">
	<script src="./JS/vue.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/general.css">
	<link rel="stylesheet" type="text/css" href="CSS/login.css">
</head>
<body>
	<form  method="post" id="login">
		<div class="loader" v-if="pageLoading==true">
			<div class="lds-ellipsis">
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
 		<div class="login-container">
 			<h1><a v-bind:href="location.href"><img id="logo" src="./Media/logo.png"></a>{{title}}</h1>
 			<div class="message" v-if="message.length>0">{{message[0]}}</div>
 			<div class="error-message" v-if="error.length>0">{{error[0]}}</div>
 			<div class="input-group">
 				<label for="input-login"></label>
 				<input type="text" name="inputLogin" isvalid="true" id="input-login">
 			</div>
 			<div class="input-group">
 				<label for="input-senha"></label>
 				<input type="password" name="inputSenha" isvalid="true" id="input-senha">
 			</div>
 			<div class="input-group btn-gp">
 				<input type="button" v-on:click="resetInputs" name="Reset" value="Reset" id="Reset">
 				<input type="submit" name="Login" value="Login" id="Login">
 			</div>
 		</div>
	</form>
	</div>

	<script type="text/javascript" src="./JS/axios/axios.js"></script>
	<script type="text/javascript">
 		config = {
 			server: '127.0.0.1'
 		}

 		let Login = new Vue({
 			el: '#login',
 			data(){
 				return {
 					title: "Bluetools Gestor",
 					pageLoading: false,
 					message: [],
 					error: [],
 					location: document.location
 				}
 			},
			methods: {
				authenticate: async function(){
					this.pageLoading = true
					this.message = []
					this.error = []
					let login = document.querySelector("div.input-group #input-login")
					let senha = document.querySelector("div.input-group #input-senha")

					login.setAttribute("isvalid", "true")
					senha.setAttribute("isvalid", "true")

				let authObj = {
					login: login.value,
					senha: senha.value
				}

				if(login.value.length>0 && senha.value.length>0){
					login.setAttribute("isvalid", "true")
					senha.setAttribute("isvalid", "true")
					let adress = "http://localhost/API/auth/"
					axios.defaults.headers.post['Content-Type'] ='application/json'
					await axios.post(adress, authObj).then(response=>{
						if (JSON.parse(response.request.response).authenticated) {
							this.message.push("Login realizado com sucesso!")
							this.pageLoading = false
						}
						else{
							let error = "Erro: Login ou senha incorretos!"
							this.error.push(error)
							console.error(error)
							this.pageLoading = false
						}
					}).catch(e=>{
						this.error.push(e)
						this.pageLoading = false
					})
		        }
		        else{
		        	let error = "Erro: campos de login e senha precisam estar preenchidos!"
		        	this.error.push(error)
					console.error(error)
					if (!login.value.length>0) {
						login.setAttribute("isvalid", "false")
					}
					if (!senha.value.length>0) {
						senha.setAttribute("isvalid", "false")
					}
					this.pageLoading = false
				}
		    },
		    resetInputs: function(){
				let login = document.querySelector("div.input-group #input-login")
				let senha = document.querySelector("div.input-group #input-senha")

				login.value=""
				senha.value=""

				login.setAttribute("isvalid", "true")
				senha.setAttribute("isvalid", "true")
				this.message=[]
				this.error=[]
				console.clear()
		    }
		  }
 		})
	</script>
</body>
</html>