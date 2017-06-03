<div id="main" class="footer-align">
	<ul class="breadcrumb">
	  	<li><a href="/doacoes">Doações</a></li>
	  	<li><a href="/painel">Painel</a></li>
	  	<li><a href="#">Itens para Doar</a></li>
	</ul>

	<div class="container recebidos">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<h1><span class="fa fa-heart"></span> Itens para Doar</h1>
			</div>
				<div class="panel-body">
					
						
							<? if ( isset($busca_item) && !empty($busca_item) ): ?>
								<? for($i=0; $i < count($busca_item); $i++): ?>
								<div class="panel panel-default">
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
												<?= $busca_item[$i]["item_status"] ?>
					   	    					</p>
					   	    				</div>
										</div>
										<div class=" col-sm-3 col-md-4 text-center right-recebidos">
											<div class="btn-group">
												<p class="btn-group-vertical">
													<button  class="btn btn-warning"><i class="fa fa-pencil-square-o"></i> Alterar</button>
													<button  class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</button>
												</p>
												<p class="btn-group-vertical">
													<a class="btn btn-success" href="/doacoes/item/<?= $busca_item[$i]['item_id'] ?>"><i class="fa fa-eye"></i> Ver</a>
													<button  class="btn btn-primary"><i class="fa fa-comments-o"></i> Abrir Chat</button>
												</p>
											</div>
										</div>
									</div>
								</div>
								</div>
								<? endfor; ?>
							<?else:?>
							<div class="panel panel-default">
							<div class="panel-body" id="body-recebidos">
								<div class="alert alert-warning text-center">
									<div class="row">
										<div class="col-md-6 col-md-offset-3"><p>Opps! Você ainda não tem nenhuma doação cadastrada. <span class="fa fa-frown-o"></span></p>
										
										<a href="/doacoes/cadastrarItem">
											<div class="btn btn-primary btn-lg">
											 Faça uma Doação <span class="fa fa-heart"></span>
											</div>
										</a>
										
										</div>
									</div>
									
								</div>
							</div>
							</div>
							<? endif;?>
				</div>
		</div>	
	</div>
</div>