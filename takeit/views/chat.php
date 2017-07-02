<ul class="breadcrumb">
  	<li><a href="/inicio">Home</a></li>
  	<li><a href="/painel">Painel</a></li>
  	<li><a href="#">Bate-Papo</a></li>
</ul>

<input type="hidden" id="tipo_pessoa_chat" value="<?= $tipo_pessoa; ?>">
<input type="hidden" id="item_id" value="<?= $item_id; ?>">

<div class="container footer-align" id="mainChat">
	<div class="container-fluid">
		<h3><span class="fa fa-product-hunt"></span> Requisições do Item <?= $item_descricao; ?></h3>
		<hr>
		<div class="two-panel row">
			<div class="col-sm-4 painel-usuarios">
				<? if($mostrar_lista) $this->load->view("chat_pessoas", $interessados); ?>
			</div>
			
			<div class="col-sm-<?= (($mostrar_lista) ? "8" : "12"); ?> painel-mensagens" id="painelMsgs">
				<div class="panel panel-default">
					<div class="painel-blank">
						<span>Selecione um bate-papo ao lado</span>
						<?= var_dump($debbug); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- #page-content-wrapper  -->