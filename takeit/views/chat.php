<main id="mainChat">
	<ul class="breadcrumb">
	  <li><a href="/inicio">Home</a></li>
	  <li><a href="#">Bate-Papo</a></li>
	</ul>

	<div class="container-fluid">
		<h3><span class="fa fa-product-hunt"></span> Requisições do Item {Nome}</h3>
		<hr>
		<div class="row">
			<div class="col-sm-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div id="left-head-chat" class="col-sm-12">
								<span class="fa fa-list-ul" aria-hidden="true"> Lista de Interessados</span>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row user-card">
							<div class="col-sm-1 user-img">
								<img src="assets/img/painel_perfil.png" alt="{Nome do Usuário}" class="img-circle">
							</div>
							<div class="col-sm-9 user-name">
								<span>Usuário 1</span>	
							</div>
							<div class="col-sm-1 user-count">
								<span>3</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div id="left-head-chat" class="col-md-4">
								<span class="fa fa-user-circle"> João da Silva</span>
							</div>
							<div id="right-head-chat" class="col-md-8">
								<div class="align-item-right">
									<input class="btn btn-success" type="button" name="chat-doar" value="Doar Item">
									<input id="qtd-intens-input" class="form-control input-sm" type="number" name="qtd-itens" value="1">
									<span class="qtd-itens-totais"> de 9</span>
									<div class="dropdown">
										<button class="btn btn-link btn-lg dropdown-toggle" data-toggle="dropdown">
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
							<div class="col-sm-12">
								<div class="alert alert-danger">
									Teste
								</div>
								<div class="alert alert-success">
									Teste
								</div>	
							</div>
							<!-- <div class="col-sm-12">								 -->
								<form class="form-group" id="formChat">
									<div class="form-group">
										<div class="col-sm-11">
											<input type="text" class="form-control" name="msg" id="inputMsg" placeholder="Mensagem...">
										</div>
										<div class="col-sm-1 text-left">
											<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>	
										</div>
									</div>
								</form>
							<!-- </div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main><!-- #page-content-wrapper  -->