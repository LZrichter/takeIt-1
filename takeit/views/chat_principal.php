<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<a href="<?= base_url().'usuario/visualizar/'.$usuario_id; ?> ">
				<div id="left-head-chat" class="col-xs-4 col-sm-4 col-md-4">
					<div class="col-xs-1 col-md-1 user-img-principal">
						<img src="<?= $imagem_link; ?>" alt="<?= $usuario_nome; ?>" class="img-circle">
					</div>
					<div class="col-xs-6">
						<h4><span id="nomePessoa"><?= $usuario_nome; ?></span></h4>
					</div>
				</div>
			</a>
			<div id="right-head-chat" class="col-xs-8 col-sm-8 col-md-8">
				<div class="align-item-right">
					<? $restante = $qtde["itens"] - $qtde["doados"];
					
					if($usuario_doacao == true){ 
						if($tipo_pessoa == "Beneficiário" && $usuario_doacao){ ?>
							<div class="alert alert-success" style="margin: -4px -8px -5px 0;">
								<strong>
									Doação realizada!
									<a href="<?= base_url(); ?>">Agradeça o Doador! </a>
								</strong>
							</div>
						<? }else{ ?>
							<div class="alert alert-success" style="margin: -4px -8px -5px 0;">
								<strong>Doação realizada!</strong>
							</div>
						<? } ?>
					<? }else if($restante <= 0){ 
						if($tipo_pessoa == "Beneficiário"){ ?>
							<div class="alert alert-warning" style="margin: -4px -8px -5px 0;">
								<strong>Item doado para outro!</strong>
							</div>
						<? }else{ ?>
							<div class="alert alert-success" style="margin: -4px -8px -5px 0;">
								<strong>Todos os itens doados.</strong>
							</div>
						<? } ?>
					<? }else if($tipo_pessoa == "Doador"){ ?>
						<input type="button" id="doarButton" class="btn btn-success" value="Doar Item" onclick="doarItem();">
						<? if($restante == 1){ ?>
							<span style=" padding: 0 4px 0 2px;">1 Item</span>
							<input type="hidden" name="qtd-itens" class="form-control input-sm" id="qtd-intens-input" value="1" maxlength="1">
						<? }else{ ?>
							<input type="number" name="qtd-itens" class="form-control input-sm" id="qtd-intens-input" value="1" onchange="changeNumItens(this);">
							<span class="qtd-itens-totais" style="margin: 0 5px 0 0;"> de <span id="qtdeRestante"><?= $restante; ?></span> </span>
						<? } ?>
						<button name="chat-doar" class="btn btn-danger" data-toggle="tooltip" title="Cancelar Bate-Papo com esse usuário"><i class="fa fa-times-circle"></i></button>
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
			$("#<?= $id_ultima_msg; ?>").focus();
			$("#inputMsg").val("").focus();
			$('[data-toggle="tooltip"]').tooltip();
		}, 100);
	</script>
	<div class="panel-footer" <?= ((!$usuario_doacao && $restante <= 0) ? 'data-toggle="tooltip" title="Não é possivel mais realizar um bate-papo, pois o produto já foi doado para outra(s) pessoa(s)."' : ''); ?> >
		<div class="row">
			<form class="form-group" id="formChat">
				<div class="form-group col-sm-12">
					<div class="col-xs-11 col-sm-11">
						<input type="text" class="form-control" name="msg" id="inputMsg" placeholder="Mensagem..." autocomplete="off"  <?= ((!$usuario_doacao && $restante <= 0) ? "disabled='true'" : ""); ?>>
					</div>
					<button type="submit" class="btn btn-primary col-xs-1 col-sm-1" <?= ((!$usuario_doacao && $restante <= 0) ? "disabled='true'" : ""); ?>>
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