<ul class="breadcrumb">
  	<li><a href="#"><?= $titulo ?></a></li>
</ul>

<div class="container footer-align" id="main">
	<div class="panel-heading text-center">
		<h1><span class="fa fa-dashboard"></span> <?= $titulo ?></h1>
	</div>
	<ul class="flex-container">
		<!-- BOTÃO 1 -->
	  	<li class="flex-item">
		  	<a href="/painel/denuncias">
		  		<div class="painel-admin-div">
		  			<img src="<?=base_url()?>/assets/img/painel_denuncias.png">
		  			<h2>Denúncias Pendentes</h2>
		  		</div>
		  	</a>
		  	<label class="badge"><?= $pendentes ?></label>
	  	</li>
	  	<!-- BOTÃO 2 -->
	  	<li class="flex-item">
		  	<a href="/painel/denunciasIgnoradas">
		  		<div class="painel-admin-div">
		  			<img src="<?=base_url()?>/assets/img/painel_denuncias_ignoradas.png">
		  			<h2>Denúncias Ignoradas</h2>
		  		</div>
		  	</a>
		  	<label class="badge"><?= $ignoradas ?></label>
	  	</li>
	  	<!-- BOTÃO 3 -->
	  	<li class="flex-item">
		  	<a href="/painel/denunciasResolvidas">
		  		<div class="painel-admin-div">
		  			<img src="<?=base_url()?>/assets/img/painel_denuncias_resolvidas.png">
		  			<h2>Denúncias Resolvidas</h2>
		  		</div>
		  	</a>
		  	<label class="badge"><?= $resolvidas ?></label>
	  	</li>
	  	<!-- BOTÃO 4 -->
	  	<li class="flex-item">
		  	<a href="/painel/doacoesCanceladas">
		  		<div class="painel-admin-div">
		  			<img src="<?=base_url()?>/assets/img/painel_doacoes_canceladas.png">
		  			<h2>Doações Canceladas</h2>
		  		</div>
		  	</a>
		  	<label class="badge"><?= $itens_cancelados ?></label>
	  	</li>
	  	<!-- BOTÃO 5 -->
	  	<li class="flex-item">
		  	<a href="/painel/usuariosBloqueados">
		  		<div class="painel-admin-div">
		  			<img src="<?=base_url()?>/assets/img/painel_users_bloqueados.png">
		  			<h2>Usuários Bloqueados</h2>
		  		</div>
		  	</a>
			<label class="badge"><?= $users_bloqueados ?></label>
	  	</li>
	  	<!-- BOTÃO 6 -->
	  	<li class="flex-item">
		  	<a href="/painel/doacoesRealizadas">
		  		<div class="painel-admin-div">
		  			<img src="<?=base_url()?>/assets/img/painel_doados.png">
		  			<h2>Doações Concretizadas</h2>
		  		</div>
		  	</a>
			<label class="badge"><?= $itens_doados ?></label>
	  	</li>
	</ul>
</div>