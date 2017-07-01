<ul class="breadcrumb">
  	<li><a href="#">Meu Painel</a></li>
</ul>

<div class="container footer-align" id="main">
	<div class="panel-heading text-center">
		<h1><span class="fa fa-dashboard"></span> Meu Painel</h1>
	</div>
	<ul class="flex-container">
		<!-- BOTÃO 1 -->
	  	<? if( $this->session->userdata('user_tipo') == 'Pessoa' ):?>
		  	<li class="flex-item">
			  	<a href="/Painel/ofertas">
			  		<div>
			  			<img src="<?=base_url()?>/assets/img/painel_doar.png">
			  			<h2>Itens para Doar</h2>
			  		</div>
			  	</a>
		  	</li>
		  	<!-- BOTÃO 2 -->
		  	<li class="flex-item">
			  	<a href="/Painel/doados">
			  		<div>
			  			<img src="<?=base_url()?>/assets/img/painel_doados.png">
			  			<h2>Minhas Doações</h2>
			  		</div>
			  	</a>
		  	</li>
	  	<? endif; ?>
	  	<!-- BOTÃO 3 -->
	  	<li class="flex-item">
		  	<a href="/doacoes">
		  		<div>
		  			<img src="<?=base_url()?>/assets/img/painel_doacoes.png">
		  			<h2>Todas Doações</h2>
		  		</div>
		  	</a>
	  	</li>
	  	<!-- BOTÃO 4 -->
	  	<li class="flex-item">
		  	<a href="/Painel/interesses">
		  		<div>
		  			<img src="<?=base_url()?>/assets/img/painel_receber.png">
		  			<h2>Itens para Receber</h2>
		  		</div>
		  	</a>
	  	</li>
	  	<!-- BOTÃO 5 -->
	  	<li class="flex-item">
		  	<a href="/Painel/recebidos">
		  		<div>
		  			<img src="<?=base_url()?>/assets/img/painel_recebidos.png">
		  			<h2>Itens Recebidos</h2>
		  		</div>
		  	</a>
	  	</li>
	  	<!-- BOTÃO 6 -->
	  	<li class="flex-item">
		  	<a href="/Usuario/perfil">
		  		<div>
		  			<img src="<?=base_url()?>/assets/img/painel_perfil.png">
		  			<h2>Dados da Conta</h2>
		  		</div>
		  	</a>
	  	</li>
	</ul>
</div>