<ul class="breadcrumb">
  	<li><a href="/inicio">Home</a></li>
  	<li><a href="/painel">Painel</a></li>
  	<li><a href="#">Bate-Papo</a></li>
</ul>

<div class="container footer-align" id="mainChat">
	<div class="container-fluid">
		<h3><span class="fa fa-product-hunt"></span> Requisições do Item {Nome}</h3>
		<hr>
		<div class="two-panel row">
			<div class="col-sm-4 painel-usuarios">
				<? $this->load->view("chat_pessoas"); ?>
			</div>
			
			<div class="col-sm-8 painel-mensagens" id="painelMsgs">
				<div class="panel panel-default">
					<div class="painel-blank">
						<span>Selecione um bate-papo ao lado</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- #page-content-wrapper  -->