<div id="main" class="footer-align">
	
	<ul class="breadcrumb">
	  	<li><a href="/doacoes">Doações</a></li>
	  	<li><a href="/painel">Painel</a></li>
	  	<li><a href="#"><?= $titulo ?></a></li>
	</ul>

	<div class="container recebidos">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<h1><span class="fa fa-heart"></span><?= $titulo ?></h1>
			</div>
				<div class="panel-body">
					<? if ( isset($denuncia) && !empty($denuncia) ): ?>
						<? for($i=0; $i < count($denuncia); $i++): ?>
						<div class="panel panel-default " id="panel-<?= $denuncia[$i]['denuncia_id']?>">
						<div class="panel-body" id="body-recebidos">
							<div class="row">
								<div class="col-sm-9 col-md-8 text-center left-recebidos">
			   	    				<div class="text-left">
			   	    					<p><strong>Item: </strong>
			   	    					<a href="/doacoes/item/<?= $item[$i][0]["item_id"] ?>" ><?= $item[$i][0]["item_descricao"] ?>&nbsp<i class="fa fa-external-link"></i></a>
			   	    					</p>
			   	    					<p><strong>Denúncia: </strong>
			   	    					<?= $denuncia[$i]["denuncia_text"] ?>
			   	    					</p>
			   	    					<p><strong>Usuário x9: </strong>
			   	    						<a href="#" ><?= $usuarios_xnove[$i]["nome"] ?>&nbsp<i class="fa fa-external-link"></i></a>
			   	    					</p>
			   	    					<p><strong>Usuário Vacilão: </strong>
			   	    						<a href="#" ><?= $usuarios_vacilao[$i]["nome"] ?>&nbsp<i class="fa fa-external-link"></i></a>
			   	    					</p>
			   	    					<p><strong>Data: </strong>
			   	    						<?
			   	    							$date = new DateTime($denuncia[$i]["denuncia_data"]);
												echo $date->format('d/m/Y');
			   	    						?>
			   	    					</p>
			   	    					<p><strong>Status: </strong>
										<? if ($denuncia[$i]["denuncia_status"] == 'Aberta'):?>
											<span class="label label-success"><?= $denuncia[$i]["denuncia_status"] ?></span>
										<? elseif( $denuncia[$i]["denuncia_status"] == 'Ignorada' ):?>
											<span class="label label-warning"><?= $denuncia[$i]["denuncia_status"] ?></span>
										<? elseif( $denuncia[$i]["denuncia_status"] == 'Resolvida' ):?>
											<span class="label label-primary"><?= $denuncia[$i]["denuncia_status"] ?></span>
										<? else: ?>
											<span class="label label-default"><?= $denuncia[$i]["denuncia_status"] ?></span>
										<? endif; ?>
			   	    					</p>
			   	    				</div>
								</div>
								<div class=" col-sm-3 col-md-4 text-center right-recebidos">
									<? if ($denuncia[$i]["denuncia_status"] == 'Aberta'):?>
									<div class="btn-group">
										<p class="btn-group-vertical">
											<a class="btn btn-success btn-ignorar" 
												data-toggle="modal" 
												data-target="#action-modal" 
												data-id="<?=$denuncia[$i]["denuncia_id"]?>"
												data-title="Você deseja Ignorar esta denúncia?"
												data-panel="panel-<?= $denuncia[$i]['denuncia_id']?>"
											>
												<i class="fa fa-hand-peace-o"></i> Ignorar Denúncia
											</a>
											<a class="btn btn-warning btn-usuario" 
												data-toggle="modal" 
												data-target="#action-modal" 
												data-id="<?= $denuncia[$i]['usuario_vacilao']?>"
												data-denuncia ="<?= $denuncia[$i]['denuncia_id']?>"
												data-title="Você deseja Bloquear este Usuário? Isso irá desativa-lo do sistema"
												data-panel="panel-<?= $denuncia[$i]['denuncia_id']?>"
											>
												<i class="fa fa-ban"></i> Bloquear Vacilão
											</a>
											<a class="btn btn-danger btn-item" 
												data-toggle="modal" 
												data-target="#action-modal" 
												data-id="<?= $denuncia[$i]['item_vacilao']?>"
												data-denuncia ="<?= $denuncia[$i]['denuncia_id']?>"
												data-title="Você deseja Cancelar este Item?"
												data-panel="panel-<?= $denuncia[$i]['denuncia_id']?>"
											>
												<i class="fa fa-trash"></i> Cancelar Item
											</a>
										</p>
									</div>
									<? endif; ?>
								</div>
							</div>
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


<!-- Modal -->
<div class="modal fade" id="action-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="action-modal-title"></h4>
      </div>
      <div class="modal-body" id="action-modal-body">
       Caso você deseje processeguir com esta ação a mesma não poderá ser revertida.
      </div>
      <div class="modal-footer">
        <button id="modal-sim-btn" type="button" class="btn btn-primary">Sim</button>
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
