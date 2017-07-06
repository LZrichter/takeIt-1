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
<main id="mainItem" class="footer-align">
<div class="container">
	<div class="row">
	  	<div class="panel panel-default">
	  		<div class="panel-heading">
	  			<h2><span class="fa fa-archive"></span> <?= $item[0]["item_descricao"] ?></h2>
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
						<p><strong>Categoria:</strong> <?= $categoria[0]["categoria_nome"] ?></p>
						<p>	
							<strong>Doador: </strong>
							<a href="/Usuario/visualizar/<?= $dadosDoador['id'];?>"><?= $dadosDoador['nome'] ?> <span class="fa fa-external-link"></span></a>
						</p>
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
	  		<!-- Mensagem com os erros  -->
			<div class="form-group" id="div_mensagem">
				<div id="mensagem"></div>
			</div>
			<!-- /Mensagem com os erros -->
	  		<? if($item[0]["usuario_id"] != $user_id): ?>
		  		<div class="panel-footer text-center">
		  			<? if($interessado): ?>
						<button type="button" class="btn btn-primary btn-lg" value="remover" onclick="interesse(this,<?=$item[0]["item_id"]?>);">
							<i class="fa fa-minus-circle"></i> Remover interesse
						</button>
					<? else : ?>
						<button type="button" class="btn btn-primary btn-lg" value="adicionar" onclick="interesse(this,<?=$item[0]["item_id"]?>);">
							<i class="fa fa-heart"></i> Manifestar interesse
						</button>
					<? endif; ?>

		  			<button id="btn-reportar" class="btn btn-danger btn-lg" 
		  			data-toggle="popover"
		  			><span class="fa fa-flag"></span> Reportar Doação</button>
		  		</div>
		  		<div id="popover-content" style="display: none; width: 100%" >
				    <div class="container" style=" width: 100% ">
					    <div class="row" style="padding-top: 10px;">
					        <label id="sample" class="text-center">
					            <form id="mainForm" class="form-group" name="mainForm" method="post">
								    <p>
								        <textarea class="form-control" id="denuncia_text" rows="8" cols="20" name="denuncia_text" placeholder="Digite aqui o motivo de sua reclamação..." required ></textarea>
								    </p>
								    <p>
								        <input type="hidden" name="item_vacilao" value="<?= $item[0]["item_id"] ?>"/>
								        <input type="hidden" name="usuario_vacilao" value="<?= $item[0]["usuario_id"] ?>"/>
								        <input type="hidden" name="usuario_x9" value="<?= $this->session->userdata('user_id') ?>"/>
								        <input class="btn btn-danger btn-denunciar" type="submit" name="Submit" value="Denunciar" />
								    </p>
								</form>
					        </label>
					    </div>
				    </div> 
				</div>
			<? endif; ?>
	  	</div>
  	</div>
  </div>
</main>

<!-- Modal de mensagem -->
<div class="modal fade" id="mensagem-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel"></h4>
      </div>
      <div class="modal-body" id="modalMsg">
        
      </div>
      <div class="modal-footer">
 		<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div> <!-- /.modal -->