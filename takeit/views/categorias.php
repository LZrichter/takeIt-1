<? if($usuario['nivel']!="Instituição"){
	echo "Página não encontrada";
	exit;
} ?>
<ul class="breadcrumb">
  	<li><a href="/painel">Painel</a></li>
  	<li><a href="#">Categorias de Interesse</a></li>
</ul>

<div class="container footer-align" id="main">
	<div class="row">
	  	<div class="panel panel-default">
	  		<div class="panel-heading text-center">
	  			<h2><span class="fa fa-list-alt"></span> Categorias de Interesse</h2>
	  		</div>
	  		<div class="panel-body">
	  		<? //var_dump($categorias_interesse)?>
	  			<div class="col-md-8 col-md-offset-2">
	  				<form class="form-group form-horizontal" enctype="multipart/form-data" id="form_categorias" method="POST">
					  	<div class="form-group text-center">
					  	  	<h4>Categorias de Interesse</h4>
			  	  	  		<hr>
					  	</div>
					  	<div id="paizao">
						  	<? if(isset($categorias_interesse) && count($categorias_interesse)>0){
						  		foreach ($categorias_interesse as $indice => $id_cat) {?>
						  		<!-- >>>>>>>>>>>>> CATEGORIA -->
							  	<div class="form-group">
							  	  	<label for="select_categoria" class="col-xs-3 col-sm-2 col-md-2 control-label">Categoria</label>
							  	  	<div class="col-xs-5 col-sm-7 col-md-7" id="div_select">
							  	  	  	<select class="form-control" name="categoria[]" id="select_categoria">
							  	  	  		<? if(isset($categorias)){ ?>
							  	  	  			<option selected="true" disabled="true" value="0">Selecione...</option>
												<? foreach ($categorias as $n => $val){ ?>
													<option value="<?= $val['categoria_id']; ?>" <?=($val['categoria_id']==$id_cat)?'selected':''?>><?= $val['categoria_nome']; ?></option>
												<? }
											}else{ ?>
												<option selected="true" disabled="true">Ocorreu um erro, tente recarregar a página!</option>
											<? } ?>
										</select>
							  	  	</div>
						  	  	  	<div class="col-xs-4 col-sm-3 col-md-3">
							  	  	  	<button type="button" class="btn btn-primary" onclick="adicionaCategoria(this);"><span class="fa fa-plus"></span></button>
							  	  	  	<button type="button" class="btn btn-danger" onclick="removerCategoria(this);"><span class="fa fa-minus"></span></button>
							  	  	</div>
							  	</div>
						  		<!-- <<<<<<<<<<<<< CATEGORIA -->
						  	<? } 
						  	} else {?>
								<div class="form-group">
							  	  	<label for="select_categoria" class="col-xs-3 col-sm-2 col-md-2 control-label">Categoria</label>
							  	  	<div class="col-xs-5 col-sm-7 col-md-7" id="div_select">
							  	  	  	<select class="form-control" name="categoria[]" id="select_categoria">
							  	  	  		<? if(isset($categorias)){ ?>
							  	  	  			<option selected="true" disabled="true" value="0">Selecione...</option>
												<? foreach ($categorias as $n => $val){ ?>
													<option value="<?= $val['categoria_id']; ?>"><?= $val['categoria_nome']; ?></option>
												<? }
											}else{ ?>
												<option selected="true" disabled="true">Ocorreu um erro, tente recarregar a página!</option>
											<? } ?>
										</select>
							  	  	</div>
						  	  	  	<div class="col-xs-4 col-sm-3 col-md-3">
							  	  	  	<button type="button" class="btn btn-primary" onclick="adicionaCategoria(this);"><span class="fa fa-plus"></span></button>
							  	  	  	<button type="button" class="btn btn-danger" onclick="removerCategoria(this);"><span class="fa fa-minus"></span></button>
							  	  	</div>
							  	</div>
							<? } ?>
						</div>
						<!-- Mensagem com os erros  -->
	  					<div class="form-group" id="div_mensagem">
					  	  	<div class="col-sm-10 col-sm-offset-1 text-center">
					  	  	  	<div id="mensagem"></div>
					  	  	</div>
			  			</div>
						<!-- /Mensagem com os erros -->
  						<div class="col-sm-offset-5 col-sm-6">
		        			<button type="submit" class="btn btn-lg btn-success" id="btnSend">
		        				<span class="fa fa-save"></span> Salvar
	        				</button>
		        		</div>
					</form>
	  			</div>
	  		</div>
	  		<div class="panel-footer text-center"></div>
	  	</div>
  	</div>
</div>