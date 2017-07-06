<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<a href="<?= base_url().'usuario/visualizar/'.$usuario_id; ?> ">
				<div id="left-head-chat" class="col-xs-7 col-sm-7 col-md-7">
					<div class="col-xs-1 col-md-1 user-img-principal">
						<img src="<?= $imagem_link; ?>" alt="<?= $usuario_nome; ?>" class="img-circle">
					</div>
					<div class="col-xs-10">
						<h4><span id="nomePessoa"><?= $usuario_nome; ?></span></h4>
					</div>
				</div>
			</a>

			<div id="right-head-chat" class="col-xs-5 col-sm-5 col-md-5">
				<div class="align-item-right">
					<? $restante = $qtde["itens"] - $qtde["doados"];
					
					if($chat_bloqueado == true){
						if($tipo_pessoa == "Beneficiário"){ ?>
							<div class="alert alert-danger" style="margin: -4px -8px -5px 0;">
								<strong>Você foi bloqueado pelo doador!</strong>
							</div>
						<? }else{ ?>
							<div class="alert alert-danger" style="margin: -4px -8px -5px 0;">
								<strong>Você bloqueou esse usuário!</strong>
							</div>
						<? } 
					}else if($usuario_doacao == true){ 
						if($tipo_pessoa == "Beneficiário" && $usuario_doacao){ ?>
							<div class="alert alert-success" style="margin: -4px -8px -5px 0;">
								<strong>
									Doação realizada!
									<button class="btn btn-success btn-sm" id="agradecer" 
									data-toggle='modal' 
									data-target='#modalAgradecimento'
									data-interesse='<?= $row['interesse_id'] ?>'
									><i class="fa fa-heart-o"></i> Agradecer
									</button>
								</strong>
							</div>
						<? }else{ ?>
							<div class="alert alert-success" style="margin: -4px -8px -5px 0;">
								<strong>Doação realizada!</strong>
							</div>
						<? }
					}else if($restante <= 0){ 
						if($tipo_pessoa == "Beneficiário"){ ?>
							<div class="alert alert-warning" style="margin: -4px -8px -5px 0;">
								<strong>Item doado para outro!</strong>
							</div>
						<? }else{ ?>
							<div class="alert alert-success" style="margin: -4px -8px -5px 0;">
								<strong>Todos os itens doados.</strong>
							</div>
						<? }
					}else if($tipo_pessoa == "Doador"){ ?>
						<input type="button" class="btn btn-success" data-toggle="modal" data-target="#model_doar" value="Doar Item">
						<? if($restante == 1){ ?>
							<span style=" padding: 0 4px 0 2px;"><span id="qtdeRestante">1</span> Item</span>
							<input type="hidden" name="qtd-itens" class="form-control input-sm" id="qtde_itens" value="1" maxlength="1">
						<? }else{ ?>
							<input type="number" name="qtd-itens" class="form-control input-sm" id="qtde_itens" value="1">
							<span class="qtd-itens-totais" style="margin: 0 5px 0 0;"> de <span id="qtdeRestante"><?= $restante; ?></span> </span>
						<? } ?>
						<button name="chat-doar" class="btn btn-danger" rel="tooltip" data-toggle="modal" data-target="#model_cancelar" title="Cancelar Bate-Papo com esse usuário"><i class="fa fa-times-circle"></i></button>
					<? } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-12 painel-mensagens" id="centro_mensagens">
				<? if(isset($chat["tipo"]) && $chat["tipo"] == "info"){
				}else{
					foreach($chat as $i => $msg){
						if($msg["chat_quem"] == $tipo_pessoa){
							$class_caixa_chat = "alert alert-info col-sm-8 col-sm-offset-4 text-right";
							$class_data_chat = "data-enviado-direita pull-left";
						}else{
							$class_caixa_chat = "alert alert-success col-sm-8";
							$class_data_chat = "data-enviado-esquerda pull-right";
						} 

						$id_ultima_msg = "chat_mensagem_".$msg["chat_id"]; 
						$chat_id_ultima = $msg["chat_id"]; ?>
							
						<div class="<?= $class_caixa_chat; ?>" id="<?= $id_ultima_msg; ?>" tabindex="1">
							<p><?= $msg["chat_text"]; ?></p>
							<div class="<?= $class_data_chat; ?>">Enviado: <?= $msg["chat_data_formatada"]; ?></div>
						</div>
					<? }
				} ?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var time = setTimeout(function(){
			<?= (isset($id_ultima_msg) ? "$('#".$id_ultima_msg."').focus();" : ""); ?>
			$("#inputMsg").val("").focus();
			$('[rel="tooltip"]').tooltip();
		}, 100);
	</script>
	<? if($chat_bloqueado == true){
		if($tipo_pessoa == "Beneficiário")
			$dataToggle = 'rel="tooltip" title="Não é possivel mais realizar um bate-papo, você foi bloqueado pelo doador."';
		else
			$dataToggle = 'rel="tooltip" title="Não é possivel mais realizar um bate-papo, você bloqueou esse usuário."';
	}else if(!$usuario_doacao && $restante <= 0)
		$dataToggle = 'rel="tooltip" title="Não é possivel mais realizar um bate-papo, pois o produto já foi doado para outra(s) pessoa(s)."'; 
	else $dataToggle = ""; ?>
	<div class="panel-footer" <?= $dataToggle; ?>>
		<div class="row">
			<form class="form-group" id="formChat">
				<div class="form-group col-sm-12">
					<div class="col-xs-11 col-sm-11">
						<input type="text" class="form-control" name="msg" id="inputMsg" placeholder="Mensagem..." autocomplete="off"  <?= (($chat_bloqueado == true || (!$usuario_doacao && $restante <= 0)) ? "disabled='true'" : ""); ?>>
					</div>
					<button type="submit" class="btn btn-primary col-xs-1 col-sm-1" <?= (($chat_bloqueado == true || (!$usuario_doacao && $restante <= 0)) ? "disabled='true'" : ""); ?>>
						<i class="fa fa-paper-plane" aria-hidden="true"></i>
					</button>
				</div>

				<input type="hidden" id="selecionado_img_pessoa" value="<?= $imagem_link; ?>">
				<input type="hidden" id="selecionado_usuario_id" value="<?= $usuario_id; ?>">
				<input type="hidden" name="tipo_pessoa" value="<?= $tipo_pessoa; ?>">
				<input type="hidden" name="interesse_id" value="<?= $interesse_id; ?>">
				<input type="hidden" id="id_ultima_msg" value="<?= (isset($chat_id_ultima) ? $chat_id_ultima : ""); ?>">
			</form>
		</div>
	</div>
</div>

<!-- MODAL ALERTA -->
<div class="modal fade" id="modal_aviso" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="alert alert-danger" id="modal_alerta" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span id="modal_msg"></span>
            <div class="botoes">
            	<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Sair</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CANCELAR -->
<div class="modal fade" id="model_cancelar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span id="modal_msg">Desejá realmente cancelar o bate-papo com esse usuário?</span>
            <div class="botoes">
            	<button type="button" class="btn btn-default" id="botao_cancelar_sim" data-dismiss="modal">Sim</button>
            	<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DOAR -->
<div class="modal fade" id="model_doar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span id="modal_msg">Deseja realmente doar para esse usuário?</span>
            <div class="botoes">
            	<button type="button" class="btn btn-default" id="botao_doar_sim" data-dismiss="modal">Sim</button>
            	<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AGRADECER -->
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


<!-- MODAL AGRADECER -->
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