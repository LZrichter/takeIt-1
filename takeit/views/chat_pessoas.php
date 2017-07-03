<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div id="left-head-chat" class="col-md-12">
				<h4><span class="fa fa-list-ul" aria-hidden="true"></span> Lista de Interessados</h4>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<? if(isset($interessados)){
			if(isset($interessados["tipo"]) && $interessados["tipo"] == "erro"){ ?>
				<div class="alert alert-info text-center">
					<?= $interessados["msg"]; ?>
				</div>
			<? }else{
				for($i = 0; $i < count($interessados); $i++){
					$user = $interessados[$i]; 
					$imagem_link = is_null($user["imagem_caminho"]) ? base_url() ."assets/img/painel_perfil.png" : base_url() . substr($user["imagem_caminho"], 2); 

					$conta_num = 0;
					if(isset($conta_nao_lidas)){
						foreach($conta_nao_lidas as $j => $conta){
							if($user["usuario_id"] == $conta["usuario_id"])
								$conta_num = $conta["num"];
						}
					} ?>

					<div class="row user-card" name="userButton" data-usuario-nome="<?= $user["usuario_nome"]; ?>" data-usuario-id="<?= $user["usuario_id"]; ?>" data-imagem-link="<?= $imagem_link; ?>" data-interesse-id="<?= $user["interesse_id"]; ?>">
						<div class="col-xs-1 col-md-1 user-img">
							<img src="<?= $imagem_link; ?>" alt="<?= $user["usuario_nome"]; ?>" class="img-circle">
						</div>
						<div class="col-xs-9 col-md-9 user-name">
							<p><?= $user["usuario_nome"]; ?></p>	
						</div>
						<div class="col-xs-1 col-md-1 user-count" data-interesse-id="<?= $user["interesse_id"]; ?>">
							<p id="naoLidas_<?= $user["usuario_id"]; ?>_<?= $user["interesse_id"]; ?>"><?= $conta_num; ?></p>
						</div>
					</div>
				<? }
			}
		} ?>
	</div>
</div>