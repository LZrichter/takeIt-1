<main id="mainItem" class="footer-align">

<ul class="breadcrumb">
  <li><a href="/inicio">Home</a></li>
  <li><a href="/doacoes">Doações</a></li>
  <li><a href="#">Item</a></li>
</ul>

<div class="container">
	<div class="row">
	  	<div class="panel panel-default">
	  		<div class="panel-heading text-center">
	  			<h2>Cadastro de doação</h2>
	  		</div>
	  		<div class="panel-body">
	  			<div class="col-md-8 col-md-offset-2">
	  				<form class="form-group form-horizontal" enctype="multipart/form-data" id="doacaoForm" method="post" action="teste">
	  		<!-- Mensagem com os erros  -->
	  					<div class="form-group" id="div_mensagem" style="display: none;">
					  	  	<div class="col-sm-10 col-sm-offset-2 text-center">
					  	  	  	<div id="mensagem"></div>
					  	  	</div>
			  			</div>
			<!-- /Mensagem com os erros -->
					  	<div class="form-group descricao-group">
					  	  	<label for="input_descricao" class="col-sm-2 control-label ">Descrição</label>
					  	  	<div class="col-sm-10 input">
					  	  	  	<input type="text" class="form-control" id="input_descricao" name="input_descricao" placeholder="Descrição do item" value="<?php echo set_value('input_descricao'); ?>">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<div class="categoria-group">
					  	  		<label for="select_categoria" class="col-sm-2 control-label">Categoria</label>
					  	  		<div class="col-sm-6">
					  	  		  	<select class="form-control" id="select_categoria" name="select_categoria">
									  <option>Selecione...</option>
									  	<? foreach ($categorias as $key => $value):?> -->
											<option id="<?= $categorias[$key]['categoria_id']?>"><?= $categorias[$key]['categoria_nome'] ?></option>
										<? endforeach; ?>
									</select>
					  	  		</div>
					  	  	</div>
				  	  	  	<div class="quantidade-group">
				  	  	  		<label for="input_qtde" class="col-sm-2 control-label">Quantidade</label>
				  	  	  		<div class="col-sm-2 input">
						  	  	  	<input type="number" class="form-control" id="input_qtde" name="input_qtde" placeholder="0">
						  	  	</div>
				  	  	  	</div>
					  	</div>
					  	<div class="form-group detalhes-group">
					  	  	<label for="area_detalhes" class="col-sm-2 control-label">Detalhes do Item</label>
					  	  	<div class="col-sm-10 input">
					  	  	  	<textarea class="form-control" id="area_detalhes" name="area_detalhes" rows="5" placeholder="Descreva aqui o máximo de detalhes do seu item"></textarea>
					  	  	</div>
					  	</div>
					  	<div class="form-group fotos-group">
					  		<label class="col-sm-2 control-label">Fotos do item</label>
					  	  	<div class="col-sm-2">
					  	  		<label for="imagem1">
					  	  	  		<img class="img-rounded add-img" id="img-1" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	  	</label>
					  	  	  	<div class="input">
					  	  	  		<input name="imagem1" id="imagem1"  type="file" accept="image/*"  style="visibility: hidden">

					  	  	  	</div>
					  	  	</div>
					  	  	<div class="col-sm-2">
					  	  	  	<label for="imagem2">
					  	  	  		<img class="img-rounded add-img" id="img-2" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	  	</label>
					  	  	  	<input name="imagem2" id="imagem2"  type="file" accept="image/*" style="visibility: hidden">
					  	  	</div>
					  	  	<div class="col-sm-2">
					  	  	  	<label for="imagem3">
					  	  	  		<img class="img-rounded add-img" id="img-3" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	  	</label>
					  	  	  	<input name="imagem3" id="imagem3"  type="file" accept="image/*" style="visibility: hidden">
					  	  	</div>
					  	  	<div class="col-sm-2">
					  	  	  	<label for="imagem4">
					  	  	  		<img class="img-rounded add-img" id="img-4" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	  	</label>
					  	  	  	<input name="imagem4" id="imagem4"  type="file" accept="image/*" style="visibility: hidden">
					  	  	</div>
					  	  	<div class="col-sm-2">
					  	  	  	<label for="imagem5">
					  	  	  		<img class="img-rounded add-img" id="img-5" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	  	</label>
					  	  	  	<input name="imagem5" id="imagem5"  type="file" accept="image/*" style="visibility: hidden">
					  	  	</div>
					  	</div>
					  	<div class="panel-footer text-center">
	  						<div class="form-group">
	  							<button class="btn btn-danger btn-lg" type="button"><span class="fa fa-eraser"></span> Limpar</button>
	  							
	  							<button class="btn btn-success btn-lg" name="doacaoSubmit" type="submit"><span class="fa fa-pencil-square-o"></span> Cadastrar</button>
	  						</div>
	  					</div>
					</form>
	  			</div>
	  		</div>
	  		
	  	</div>
  	</div>
  </div>
</main>