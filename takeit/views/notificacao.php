<main id="mainLogin" class="footer-align">
	<div class="container">
		<?php echo "<pre>"; print_r($notificacoes); echo "</pre>";?>

		<?php if (isset($notificacoes['Error'])) {
			echo '<div class="panel-body">
				<div class="alert alert-warning text-center">
						<div class="row">
							<div class="col-md-6 col-md-offset-3"><h3>Parece que você não possui nenhuma notificação.</h3>					
							</div>
						</div>
					</div>
			</div>';
		} else {
			foreach ($notificacoes as $row) {
				switch ($row["notificacao_tipo"]) {
					case 'doacao_adquirida': ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-success" ?>">
							<strong>Doação Adquirida!</strong> O item "<?= $row["item_descricao"] ?>", pelo qual você estava interessado foi doado para você.<br/>
							<a class="btn btn-success" href="#"><i class="fa fa-heart-o"></i> Agradecer</a>
							<a href="#" class="btn btn-primary"><i class="fa fa-comments-o"></i> Abrir Chat</a>
						</div>
						<?php break;
					case 'doacao_perdida': ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-warning" ?>">
							<strong>Doação Perdida!</strong> O item "<?= $row["item_descricao"] ?>", pelo qual você estava interessado foi doado para outro usuário.
						</div>
						<?php break;
					case 'doacao_cancelada': ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-warning" ?>">
							<strong>Doação Perdida!</strong> O item "<?= $row["item_descricao"] ?>", pelo qual você estava interessado não está mais sendo doado.
						</div>
						<?php break;
					case 'nova_mensagem': ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-info" ?>">
							<strong>Nova Mensagem!</strong> O usuário "<?= $row["usuario_nome"] ?>" te mandou uma nova mensagem sobre o item "<?= $row["item_descricao"] ?>".<br />
							<a class="btn btn-success" href="#"><i class="fa fa-heart-o"></i> Agradecer</a>
							<a href="<?= base_url();?>doacoes/item/<?=$row["item_id"]?>" class="btn btn-warning"><i class="fa fa-external-link"></i> Abrir Página do Produto</a>
							<br/><strong>Modificar a consulta desse aki para exibir o nome do usuário que enviou a mensagem não o usuário que cadastrou o item!</strong>
						</div>
						<?php break;
					case 'novo_interessado': ?>
						<div class="alert <?= $row["notificacao_lida"]==1?"alert-default":"alert-info" ?>">
							<strong>Novo Interessado!</strong> O usuário "<?= $row["usuario_nome"] ?>" se interessou pelo item "<?= $row["item_descricao"] ?>" que você está doando.<br />
							<a href="#" class="btn btn-primary"><i class="fa fa-comments-o"></i> Abrir Chat</a>
							<a href="<?= base_url();?>doacoes/item/<?=$row["item_id"]?>" class="btn btn-warning"><i class="fa fa-external-link"></i> Abrir Página do Produto</a>
							<br/><strong>Modificar a consulta desse aki para exibir o nome do usuário que se interessou não o usuário que cadastrou o item!</strong>
						</div>
						<?php break;
				}
			}
		} ?>

	</div>
</main>