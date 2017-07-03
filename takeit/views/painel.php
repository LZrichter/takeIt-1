<?
	$user_tipo = $this->session->userdata('user_tipo');
?>
<ul class="breadcrumb">
  	<li><a href="#">Meu Painel</a></li>
</ul>

<div class="container footer-align" id="main">
	<div class="panel-heading text-center">
		<h1><span class="fa fa-dashboard"></span> Meu Painel</h1>
	</div>
	<ul class="flex-container">
	  	<? if($user_tipo == 'Pessoa'):?>
			<!-- BOTÃO 1 -->
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
			  			<h2>Itens Doados</h2>
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
		  			<h2>Meus Interesses</h2>
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
		  			<h2><?=($user_tipo=="Pessoa")?"Dados da Conta":"Configuração da Conta"?></h2>
		  		</div>
		  	</a>
	  	</li>
	  	<? if($user_tipo == 'Instituição'):?>
		  	<!-- BOTÃO 7 -->
		  	<li class="flex-item">
			  	<a href="/Instituicoes/categorias">
			  		<div>
			  			<img src="<?=base_url()?>/assets/img/painel_categorias.png">
			  			<h2>Categorias de Interese</h2>
			  		</div>
			  	</a>
		  	</li>
		  	<!-- BOTÃO 8 -->
		  	<li class="flex-item">
			  	<a href="/Instituicoes">
			  		<div>
			  			<img src="<?=base_url()?>/assets/img/painel_instituicao.png">
			  			<h2>Outras Instituições Cadastradas</h2>
			  		</div>
			  	</a>
		  	</li>
		<? endif; ?>
	</ul>
</div>