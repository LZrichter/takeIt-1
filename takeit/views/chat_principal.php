<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div id="left-head-chat" class="col-xs-4 col-sm-4 col-md-4">
				<div class="col-xs-1 col-md-1 user-img-principal">
					<img src="<?= $imagem_link; ?>" alt="<?= $usuario_nome; ?>" class="img-circle">
				</div>
				<div class="col-xs-3">
					<h4><span id="nomePessoa"><?= $usuario_nome; ?></span></h4>
				</div>
			</div>
			<div id="right-head-chat" class="col-xs-8 col-sm-8 col-md-8">
				<div class="align-item-right">
					<input type="button" name="chat-doar" class="btn btn-success" value="Doar Item">
					<input type="number" name="qtd-itens" class="form-control input-sm" id="qtd-intens-input" value="1">
					<span class="qtd-itens-totais"> de 9</span>
					<div class="dropdown">
						<button class="btn btn-link dropdown-toggle" data-toggle="dropdown">
							<span class="fa fa-cog"> <span class="caret"></span></span>
						</button>
					  	<ul class="dropdown-menu">
						    <li><a href="#">Enviar meus Contatos</a></li>
						    <li><a href="#">Encerrar bate papo</a></li>
						    <li><a href="#">Reportar bate papo</a></li>
					  	</ul>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-12 mensagens" id="centro_mensagens">
				<? if(isset($chat["tipo"]) && $chat["tipo"] == "info"){
				}else{
					foreach($chat as $i => $msg){
						if($msg["chat_quem"] == $tipo_pessoa){
							$class_caixa_chat = "alert alert-info col-sm-8 col-sm-offset-4 text-right";
							$class_data_chat = "data-enviado-direita pull-left";
						}else{
							$class_caixa_chat = "alert alert-success col-sm-8";
							$class_data_chat = "data-enviado-esquerda pull-right";
						} ?>

						<div class="<?= $class_caixa_chat; ?>" id="chat_mensagem_<?= $msg["chat_id"]; ?>">
							<p><?= $msg["chat_text"]; ?></p>
							<div class="<?= $class_data_chat; ?>">Enviado: <?= $msg["chat_data_formatada"]; ?></div>
						</div>
					<? }
				} ?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$("#centro_mensagens").scrollTop($("#centro_mensagens")[0].scrollHeight);
	</script>
	<div class="panel-footer">
		<div class="row">
			<form class="form-group" id="formChat">
				<div class="form-group col-sm-12">
					<div class="col-xs-11 col-sm-11">
						<input type="text" class="form-control" name="msg" id="inputMsg" placeholder="Mensagem..." autocomplete="off">
					</div>
					<button type="submit" class="btn btn-primary col-xs-1 col-sm-1">
						<i class="fa fa-paper-plane" aria-hidden="true"></i>
					</button>
				</div>

				<input type="hidden" name="tipo_pessoa" value="<?= $tipo_pessoa; ?>">
				<input type="hidden" name="interesse_id" value="<?= $interesse_id; ?>">
			</form>
		</div>
	</div>
</div>