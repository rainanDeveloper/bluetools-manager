<script type="text/javascript">
	function dropMenuRedirect(link) {
		location.href = link
	}
</script>
<header>
	<div class="topSide">
		<ul>
			<li>Cadastros
				<ul class="dropdown">
					<li onclick="dropMenuRedirect('clientes.php')">Cliente</li>
					<li onclick="dropMenuRedirect('usuarios.php')">Usuário</li>
				</ul>
			</li>
			<li>Financeiro
				<ul class="dropdown">
					<li onclick="dropMenuRedirect('pagamentos.php')">Pagamentos</li>
					<li onclick="dropMenuRedirect('recebimentos.php')">Recebimentos</li>
				</ul>
			</li>
			<li>Alterar Senha</li>
			<li onclick="dropMenuRedirect('home.php')">Painel</li>
			<li onclick="dropMenuRedirect('home.php?sair')">Sair</li>
		</ul>
	</div>
	<div class="large-buttons">
		<a href="recebimentos.php" class="lg-button">Recebimentos</a>
		<a href="pagamentos.php" class="lg-button">Pagamentos</a>
		<a href="clientes.php" class="lg-button">Clientes</a>
		<a href="contratos.php" class="lg-button">Contratos</a>
	</div>
</header>