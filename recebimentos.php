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

if (empty($_SESSION['login'])) {
	header('location: ./');
}

if (empty($_GET['dataInit'])&empty($_GET['dataInitLanc'])) {
	$dataInit = date('Y-m-01');
	$dataEnd = date('Y-m-d');
}
else{
	if (empty($_GET['dataEnd'])) {
		$dataInit = $_GET['dataInit'];
		$dataEnd = $dataInit;
	}
	else {
		$dataInit = $_GET['dataInit'];
		$dataEnd = $_GET['dataEnd'];
	}
}

$iniQuery = mysqli_query($link, "SELECT * FROM cliente INNER JOIN receber ON cliente.cli_cod = receber.receber_cliente WHERE cliente.cli_status=1".(isset($dataInit)?" AND receber.receber_data_venc BETWEEN '$dataInit' AND '$dataEnd'":'')) or die(mysqli_error($link));

$recebimentos = array();

while ($row = mysqli_fetch_assoc($iniQuery)) {
	$recebimentos[]=$row;
}

$jsonRecebimentos=json_encode($recebimentos);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Bluetools Manager - Recebimentos</title>
	<meta charset="utf-8">
	<script src="./JS/vue.js"></script>
	<link rel="shortcut icon" href="./Media/logo.png">
	<link rel="stylesheet" type="text/css" href="CSS/general.css">
	<link rel="stylesheet" type="text/css" href="./font-awesome/css/all.css">
	<link rel="stylesheet" type="text/css" href="CSS/receber.css">
</head>
<body>
	<?php 
		include 'header.component.php'
	 ?>
	<div class="content">
		<h2 class="titleReceber">Contas a receber</h2>
		<div class="optionsMenu">
			<form class="optionsForm" id="advancedSearch" onsubmit="event.preventDefault()">
				<select class="searchBy">
					<option value="0">Código</option>
					<option selected value="1">Cliente</option>
				</select>
				<input class="searchField" type="text"placeholder="Busca..."></input>
				<button class="search-btn" v-on:click="displaySearch"><i class="fas fa-search search-btn-icon"></i></button>

				<div class="optionsBtns">
					<button onclick="openAddReceberWindow()"><i class="fas fa-file"></i>Novo</button>
					<button onclick="openEditReceberWindow()"><i class="fas fa-pen"></i>Editar</button>
					<button><i class="fas fa-times"></i>Excluir</button>
					<button><i class="fas fa-print"></i>Imprimir lista</button>
				</div>
			<div v-if="search==true" class="advancedSearchContainer">
				<div class="advancedSearch">
					<div class="header">Pesquisa Avançada</div>
					<div class="content">
						<div class="input-group">
							<label>Cliente</label>
							<input type="text" name="nomeCliente" placeholder="fulano de t...">
						</div>
						<div class="input-group">
							<label>Vencimento</label>
							<div class="inputDates">
								<input type="date" name="dataInit" value="<?php echo $dataInit; ?>">
								<input type="date" name="dataEnd" value="<?php echo $dataEnd; ?>">
							</div>
						</div>
						<div class="input-group">
							<label>Lançamento</label>
							<div class="inputDates">
								<input type="date" name="dataInitLanc">
								<input type="date" name="dataEndLanc">
							</div>
						</div>
						<div class="input-group">
							<label>Forma de pagamento</label>
							<select>
								
							</select>
						</div>
					</div>
					<div class="footer">
						<button v-on:click="submitSearch">Pesquisar</button>
						<button class="close" v-on:click="hideSearch">Fechar</button>
					</div>
				</div>
			</div>
			</form>
		</div>
		<div class="contentTable">
			<table id="receberContentTbl">
				<thead>
					<tr>
						<th data-label="check"><input type="checkbox" name="headCheck" v-on:change="setAllChecked"></th>
						<th data-label="cod">Código</th>
						<th data-label="cliente">Cliente</th>
						<th data-label="valorParc">Valor parcela</th>
						<th data-label="valorReceber">Valor a receber</th>
						<th data-label="valorRecebido">Valor a recebido</th>
						<th data-label="data_lanc">Data de lanç.</th>
						<th data-label="data_venc">Data de venc.</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="rows" v-for="row in rows" onclick="selectClick(this)">
						<td class="centered"><input type="checkbox" name="checkInp" :data-id=row.cod :checked="allChecked"></td>
						<td>{{row.receber_cod}}</td>
						<td>{{row.cli_nome}}</td>
						<td class="numeric">{{maskMoney(row.receber_valor_parc)}}</td>
						<td class="numeric">{{maskMoney(row.receber_valor_parc - row.receber_valor_recebido)}}</td>
						<td>{{maskMoney(row.receber_valor_recebido)}}</td>
						<td>{{maskDate(row.receber_data_lanc)}}</td>
						<td>{{maskDate(row.receber_data_venc)}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<script type="text/javascript">
		openAddReceberWindow= ()=>{
			window.open('./receber.php?new',"_blank", "height=450, width=820, top=100, left=100");
		}


		function selectClick(handler) {
			let checkbox = handler.querySelector("input[type='checkbox']")
			if (checkbox.checked) {
				checkbox.checked = false
			}
			else{
				checkbox.checked = true
			}
		}

		let advancedSearch = new Vue({
			el: 'form#advancedSearch',
			data(){
				return{
					search: false
				}
			},
			methods: {
				displaySearch: function(){
					this.search = true
				},
				hideSearch: function(){
					this.search = false
				},
				submitSearch: function(){
					document.querySelector('form#advancedSearch').submit();
				}
			}
		})

		let tblReceber = new Vue({
			el: 'table#receberContentTbl',
			data(){
				return {
					rows: <?php echo($jsonRecebimentos); ?>,
					allChecked: false
				}
			},
			methods: {
				maskNumber: (number)=>{
					return number.toString().replace(/(\d+)\.(\d{2})(\d{0,})/g, "$1,$2")
				},
				maskDate: (date)=>{
					return date.replace(/(\d{4})\-(\d{2})\-(\d{2})/g, "$3/$2/$1")
				},
				maskMoney: function(number){
					return this.maskNumber(number).replace(/^/g, "R$ ")
				},
				setAllChecked: function(){
					if (this.allChecked) {
						this.allChecked=false
					}
					else{
						this.allChecked=true
					}
				}
			}
		})
	</script>
</body>
</html>