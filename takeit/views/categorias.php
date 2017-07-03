<ul class="breadcrumb">
  	<li><a href="/painel">Painel</a></li>
  	<li><a href="#">Categorias de Interesse</a></li>
</ul>

<div class="container footer-align" id="main">
	<div class="row">
	  	<div class="panel panel-default">
	  		<div class="panel-heading text-center">
	  			<h2><span class="fa fa-list-alt"></span> Categorias de interesse</h2>
	  		</div>
	  		<div class="panel-body">
	  		<?//var_dump($categorias)?>
	  			<div class="col-md-8 col-md-offset-2">
	  				<form class="form-group form-horizontal" enctype="multipart/form-data" id="form_perfil" method="POST">
					  	<div class="form-group text-center">
					  	  	<h4>Categorias de Interesse</h4>
			  	  	  		<hr>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="select_categoria" class="col-sm-2 control-label">Categoria</label>
					  	  	<div class="col-sm-9">
					  	  	  	<select class="form-control" id="select_categoria">
					  	  	  		<? if(isset($categorias)){ ?>
										<? foreach ($categorias as $n => $val){ ?>
											<option value="<?= $val['categoria_id']; ?>" <?//=($val['categoria_id']==$usuario['estado_uf'])?'selected':''?>><?= $val['categoria_nome']; ?></option>
										<? }
									}else{ ?>
										<option selected="true" disabled="true">Ocorreu um erro, tente recarregar a página!</option>
									<? } ?>
								</select>
					  	  	</div>
				  	  	  	<div class="col-sm-1">
					  	  	  	<button type="button" class="btn btn-primary" onclick="alert('Adicionar outra categoria de interesse!');"><span class="fa fa-plus"></span></button>
					  	  	</div>
					  	</div>
						<!-- Mensagem com os erros  -->
	  					<div class="form-group" id="div_mensagem">
					  	  	<div class="col-sm-10 col-sm-offset-2 text-center">
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