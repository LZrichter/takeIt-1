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
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div id="left-head-chat" class="col-md-12">
								<h4><span class="fa fa-list-ul" aria-hidden="true"></span> Lista de Interessados</h4>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row user-card">
							<div class="col-xs-1 col-md-1 user-img">
								<img src="assets/img/painel_perfil.png" alt="{Nome do Usuário}" class="img-circle">
							</div>
							<div class="col-xs-9 col-md-9 user-name">
								<p>Usuário 1</p>	
							</div>
							<div class="col-xs-1 col-md-1 user-count">
								<p>3</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-8 painel-mensagens">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div id="left-head-chat" class="col-xs-4 col-sm-4 col-md-4">
								<h4><span class="fa fa-user-circle"></span> João da Silva</h4>
							</div>
							<div id="right-head-chat" class="col-xs-8 col-sm-8 col-md-8">
								<div class="align-item-right">
									<input class="btn btn-success" type="button" name="chat-doar" value="Doar Item">
									<input id="qtd-intens-input" class="form-control input-sm" type="number" name="qtd-itens" value="1">
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
							<div class="col-sm-12 mensagens">
								<div class="alert alert-success col-sm-8">
									<p>Teste</p>
								</div>
								<div class="alert alert-info col-sm-8 col-sm-offset-4 text-right">
									<p>Teste</p>
								</div>
								<div class="alert alert-success col-sm-8">
									<p>Teste</p>
								</div>
								<div class="alert alert-info col-sm-8 col-sm-offset-4 text-right">
									<p>Teste</p>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<form class="form-group" id="formChat">
								<div class="form-group col-sm-12">
									<div class="col-xs-11 col-sm-11">
										<input type="text" class="form-control" name="msg" id="inputMsg" placeholder="Mensagem...">
									</div>
									<button type="submit" class="btn btn-primary col-xs-1 col-sm-1">
										<i class="fa fa-paper-plane" aria-hidden="true"></i>
									</button>
								</div>
							</form>
						</div>
			  		</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- #page-content-wrapper  -->