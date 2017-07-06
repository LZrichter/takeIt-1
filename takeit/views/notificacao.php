<main id="mainLogin" class="footer-align">
	<div class="container">
		<?php 
		$user_id = $this->session->userdata("user_id");
		if (isset($contador)) {
			echo '<div class="panel-body">
				<div class="alert alert-warning text-center">
						<div class="row">
							<div class="col-md-6 col-md-offset-3"><h3>Parece que você não possui nenhuma notificação.</h3>					
							</div>
						</div>
					</div>
			</div>';
		} else {
			$count = 0;
			foreach ($notificacoes as $row) {
				switch ($row["notificacao_tipo"]) {
					case 'doacao_adquirida': 
						if($row["usuario_id"]==$user_id) continue; ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-success" ?>">
							<strong>Doação Adquirida!</strong> O item "<?= $row["item_descricao"] ?>", pelo qual você estava interessado foi doado para você.<br/>
							<div class="botoes">
							<?php if ( isset($row["ja_agradeceu"]) && !$row["ja_agradeceu"]): ?>
								<button class="btn btn-success" id="agradecer" 
									data-toggle='modal' 
									data-target='#modalAgradecimento'
									data-interesse='<?= $row['interesse_id'] ?>'
								><i class="fa fa-heart-o"></i> Agradecer
								</button>
							<?php endif ?>
								</a>
								<a href="/chat/<?= arrumaString($notificacoes[$count]['item_descricao']) . "-" . $notificacoes[$count]['item_id']; ?>" class="btn btn-primary"><i class="fa fa-comments-o"></i> Abrir Chat</a>
							</div>
						<?php break;
					case 'doacao_perdida': 
						if($row["usuario_id"]==$user_id) continue; ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-warning" ?>">
							<strong>Doação Perdida!</strong> O item "<?= $row["item_descricao"] ?>", pelo qual você estava interessado foi doado para outro usuário.
						</div>
						<?php break;
					case 'doacao_cancelada': 
						if($row["usuario_id"]==$user_id) continue; ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-warning" ?>">
							<strong>Doação Perdida!</strong> O item "<?= $row["item_descricao"] ?>", pelo qual você estava interessado não está mais sendo doado.
						</div>
						<?php break;
					case 'novo_interessado': 
						if($row["usuario_id_interesse"]==$user_id) continue; ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-info" ?>">
							<strong>Novo Interessado!</strong> O usuário "<?= $row["usuario_nome_interesse"] ?>" se interessou pelo item "<?= $row["item_descricao"] ?>" que você está doando.<br />
							<div class="botoes">
								<a href="/chat/<?= arrumaString($notificacoes[$count]['item_descricao']) . "-" . $notificacoes[$count]['item_id']; ?>" class="btn btn-primary"><i class="fa fa-comments-o"></i> Abrir Chat</a>
								<a href="<?= base_url();?>doacoes/item/<?=$row["item_id"]?>" class="btn btn-warning"><i class="fa fa-external-link"></i> Abrir Página do Produto</a>
							</div>
						</div>
						<?php break;
				}
				$count++;
			}
		} ?>
		<div class="modal fade" id="modalAgradecimento" tabindex="-1" role="dialog" aria-labelledby="label">
		    <div class="modal-dialog">
		        <div class="modal-content">

		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                <h3 class="modal-title" id="label"><strong>Agradecer Doação</strong></h3>
		            </div>

		            <div class="modal-body">
		           		<h4>Escreva uma mensagem para agradecer a doação!</h4>
		           		
		           		<textarea class="form-control" rows="10" id="agradecimento" name="agradecimento" required></textarea>
		                
		                <div class="modal-footer">  
			                <button id="enviarAgradecimento" type="button" class="btn btn-success" data-dismiss="modal">Enviar</button>
		                </div>
		        	</div>
		    	</div>
		    </div>
		</div>

		<div class="modal fade" id="modalRetorno" tabindex="-1" role="dialog" aria-labelledby="labelRetorno">
		    <div class="modal-dialog">
		        <div class="modal-content">

		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                <h3 class="modal-title" id="labelRetorno"></h3>
		            </div>
		            <div class="modal-body" id="bodyRetorno">
		                
		        	</div>
	                <div class="modal-footer">  
		                <button id="fechar" type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
	                </div>
		    	</div>
		    </div>
		</div>
	</div>
</main>