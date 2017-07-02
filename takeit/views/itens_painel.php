<div id="main" class="footer-align">
	
	<ul class="breadcrumb">
	  	<li><a href="/doacoes">Doações</a></li>
	  	<li><a href="/painel">Painel</a></li>
	  	<li><a href="#"><?= $titulo ?></a></li>
	</ul>
	
	<div class="container recebidos">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<h1><span class="fa fa-heart"></span> <?= $titulo ?></h1>
			</div>
				<div class="panel-body">
					<? if ( isset($busca_item) && !empty($busca_item) ): ?>
						<? for($i=0; $i < count($busca_item); $i++): ?>
						<div class="panel panel-default " id="panel-<?= $busca_item[$i]['item_id']?>">
						<div class="panel-body" id="body-recebidos">
							<div class="row">
								<div class="col-sm-9 col-md-8 text-center left-recebidos">
									<div class="photo"> 
			   		           			 <img src="<?= base_url().substr($busca_item[$i]["imagem_caminho"],2)."/".$busca_item[$i]["imagem_nome"]?>" class="img-thumbnail img-responsive" alt="Imagem do Item" width="120px" height="120px" />
			   	    				</div>
			   	    				<div class="text-left">
			   	    					<p><strong>Item: </strong>
			   	    					<?= $busca_item[$i]["item_descricao"] ?>
			   	    					</p>
			   	    				
			   	    					<p><strong>Quantidade: </strong>
			   	    					<?= $busca_item[$i]["item_qtde"] ?>
			   	    					</p>
			   	    					<p><strong>Data: </strong>
			   	    						<?
			   	    							$date = new DateTime($busca_item[$i]["item_data"]);
												echo $date->format('d/m/Y');
			   	    						?>
			   	    					</p>
			   	    					<p><strong>Status: </strong>
										<? if ($busca_item[$i]["item_status"] == 'Disponível'):?>
											<span class="label label-success"><?= $busca_item[$i]["item_status"] ?></span>
										<? elseif( $busca_item[$i]["item_status"] == 'Solicitado' ):?>
											<span class="label label-warning"><?= $busca_item[$i]["item_status"] ?></span>
										<? elseif( $busca_item[$i]["item_status"] == 'Cancelado' ):?>
											<span class="label label-danger"><?= $busca_item[$i]["item_status"] ?></span>
										<? elseif( $busca_item[$i]["item_status"] == 'Doado' ):?>
											<span class="label label-primary"><?= $busca_item[$i]["item_status"] ?></span>
										<? else: ?>
											<span class="label label-default"><?= $busca_item[$i]["item_status"] ?></span>
										<? endif; ?>
			   	    					</p>
			   	    				</div>
								</div>
								<div class=" col-sm-3 col-md-4 text-center right-recebidos">
									<div class="btn-group">
										<? if( isset($qualTela) && $qualTela == 1 ): ?>
											<p class="btn-group-vertical">
												<a href="/doacoes/alterarItem/<?= $busca_item[$i]['item_id'] ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o"></i> Alterar</a>
												<button id="cancelarDoacaoBtn" data-id="<?= $busca_item[$i]['item_id']?>" class="btn btn-danger btn-modal" data-toggle="modal" data-target="#delete-modal"><i class="fa fa-trash"></i> Cancelar</button>

											</p>
										<? endif; ?>
										<p class="btn-group-vertical">
											<a class="btn btn-success" href="/doacoes/item/<?= $busca_item[$i]['item_id'] ?>"><i class="fa fa-eye"></i> Ver</a>
											<a href="/chat/" class="btn btn-primary"><i class="fa fa-comments-o"></i> Abrir Chat</a>
										</p>
									</div>
								</div>
								<? if(count($instituicoes_interessadas[$i]) > 0): ?>
									<div class="text-center"><a href="/instituicoes/intituicoesInteressadas/<?= $i ?>"> Existem <p class="badge" style="font-size: 10px; margin-bottom: 0px"><?= count($instituicoes_interessadas[$i]) ?></p> Instituições interessadas nessa categoria de item.</a></div>
									</div>
								<? endif; ?>
						</div>
						</div>
						<? endfor; ?>
					<?else:?>
							<div class="alert alert-warning text-center">
								<div class="row">
									<div class="col-md-6 col-md-offset-3"><h3>Opps! Você ainda não tem nenhuma doação por aqui. <span class="fa fa-frown-o"></span></h3>
									
									</div>
								</div>
							</div>
					<? endif;?>
				</div>
		</div>	
	</div>
</div>

<? if( isset($qualTela) && $qualTela == 1 ): ?>
<!-- Modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cancelar Doação?</h4>
      </div>
      <div class="modal-body">
        Deseja realmente cancelar esta doação? OBS: Ela não se tornará mais disponível, toda e qualquer transação realizada com esta doação será perdida..
      </div>
      <div class="modal-footer">
        <button id="cancelarDoacao" type="button" class="btn btn-primary">Sim</button>
 		<button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
      </div>
    </div>
  </div>
</div> <!-- /.modal -->

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



<? endif; ?>