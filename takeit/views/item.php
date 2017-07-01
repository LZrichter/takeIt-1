<main id="mainItem" class="footer-align">

<? if($_SESSION['user_id'] == $item[0]["usuario_id"]): ?>
	<ul class="breadcrumb">
	  <li><a href="/painel">Meu Painel</a></li>
	  <li><a href="/painel/ofertas">Para Doar</a></li>
	  <li><a href="#">Item</a></li>
	</ul>
<? else: ?>
	<ul class="breadcrumb">
	  <li><a href="/doacoes">Doações</a></li>
	  <li><a href="#">Item</a></li>
	</ul>
<? endif; ?>
<div class="container">
	<div class="row">
	  	<div class="panel panel-default">
	  		<div class="panel-heading">
	  			<h2><span class="fa fa-product-hunt"></span> <?= $item[0]["item_descricao"] ?></h2>
	  		</div>
	  		<div class="panel-body">
	  			<div class="col-sm-6 col-md-6 col-lg-4 text-center">
	  				<div id="myCarousel" class="carousel slide" data-ride="carousel">
	  				  <!-- Indicators -->
	  				  <ol class="carousel-indicators">
	  				    <?php $i = 0; ?>
	  				    <? foreach ($imagens as $key => $value): ?>
	  				    <? $item_class = ($i == 0) ? 'active' : ''; ?>
	  				    	<li data-target="#myCarousel" data-slide-to="<? $key ?>" class="<?= $item_class; ?>"></li>
	  				    <? $i++; ?>
	  					<? endforeach; ?>
	  				  </ol>
	  				
	  				  <!-- Wrapper for slides -->
	  				  <div class="carousel-inner " role="listbox">
	  					<?php $i = 1; ?>
	  				    <? foreach ($imagens as $key => $value): ?>
	  				    <? $item_class = ($i == 1) ? 'item active' : 'item'; ?>
	  				    <div class="<?= $item_class; ?>"> <!-- imagem 1 -->
	  				      <img  class="img-responsive" data-toggle="magnify" src="<?= base_url().substr($imagens[$key]['imagem_caminho'],2).'/'.$imagens[$key]['imagem_nome'] ?>" alt="violao" width="460" height="345">
	  				    </div>
	  				    <? $i++; ?>
	  					<? endforeach; ?>
	  				
	  				  </div>
	  				
	  				  <!-- Left and right controls -->
	  				  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	  				    <span class="fa fa-chevron-left" aria-hidden="true"></span>
	  				    <span class="sr-only">Anterior</span>
	  				  </a>
	  				  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	  				    <span class="fa fa-chevron-right" aria-hidden="true"></span>
	  				    <span class="sr-only">Próximo</span>
	  				  </a>
	  				</div>
	  			</div>
				<div class="col-sm-6 col-md-6 col-lg-8">
					<div class="center-block text-left">
						<p><strong>Quantidade:</strong> <?= $item[0]["item_qtde"] ?></p>
						<p><strong>Doador:</strong> <?= $dadosDoador['nome'] ?></p>
						<p><strong>Cidade/UF:</strong> <?= $dadosDoador['cidade_nome'].' / '.$dadosDoador['estado_uf'] ?></p>
						<p><strong>Status:</strong>
							<? if ($item[0]["item_status"] == 'Disponível'):?>
								<span class="label label-success"><?= $item[0]["item_status"] ?></span>
							<? elseif( $item[0]["item_status"] == 'Solicitado' ):?>
								<span class="label label-warning"><?= $item[0]["item_status"] ?></span>
							<? elseif( $item[0]["item_status"] == 'Cancelado' ):?>
								<span class="label label-danger"><?= $item[0]["item_status"] ?></span>
							<? elseif( $item[0]["item_status"] == 'Doado' ):?>
								<span class="label label-primary"><?= $item[0]["item_status"] ?></span>
							<? else: ?>
								<span class="label label-default"><?= $item[0]["item_status"] ?></span>
							<? endif; ?>
						</p>
						<p class="text-justify"><strong>Descrição:</strong> 
							<?= $item[0]['item_detalhes'] ?>
						</p>
					</div>
				</div>
	  		</div>
	  		<? if($item[0]["usuario_id"] != $user_id): ?>
		  		<div class="panel-footer text-center">
		  			<button class="btn btn-primary btn-lg" type="button"><span class="fa fa-heart"></span> Manisfestar Interesse</button>

		  			<button class="btn btn-danger btn-lg" type="button"><span class="fa fa-flag" data-toggle="popover" title="Descreva o motivo" 
		  			data-content="
		  			<textarea  rows='4' cols='50' placeholder='Informe aqui sua reclamação.. '></textarea>
		  			<button class='btn btn-success'>Denunciar</button>
		  			"
		  			data-item="<?= $item[0]["item_id"] ?>"
		  			data-xnove="<?= $this->session->userdata('user_id') ?>"
		  			data-vacilao="<?= $item[0]["usuario_id"] ?>"
		  			></span> Reportar Doação</button>
		  		</div>
			<? endif; ?>
	  	</div>
  	</div>
  </div>
</main>