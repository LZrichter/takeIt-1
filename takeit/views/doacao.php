<main id="mainItem" class="footer-align">

<? if(isset($alterar) && $alterar):?>
	<ul class="breadcrumb">
	  <li><a href="/painel">Meu Painel</a></li>
	  <li><a href="/painel/ofertas">Para Doar</a></li>
	  <li><a href="#">Alterar Item</a></li>
	</ul>
<? else: ?>
	<ul class="breadcrumb">
	  <li><a href="/inicio">Home</a></li>
	  <li><a href="/doacoes">Doações</a></li>
	  <li><a href="#">Item</a></li>
	</ul>
<? endif; ?>

<div class="container">
	<div class="row">
	  	<div class="panel panel-default">
	  		<div class="panel-heading text-center">
	  			<h2><?= $titulo ?></h2>
	  		</div>
	  		<div class="panel-body">
	  			<div class="col-md-8 col-md-offset-2">
	  				<form class="form-group form-horizontal" enctype="multipart/form-data" id="doacaoForm" method="post">
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
					  	  		<? if(isset($alterar) && $alterar):?>
					  	  	  		<input type="text" class="form-control" id="input_descricao" name="input_descricao" value="<?= $item[0]['item_descricao']?>">
					  	  	  	<? else: ?>
					  	  	  		<input type="text" class="form-control" id="input_descricao" name="input_descricao" placeholder="Descrição/Nome do item">
					  	  	  	<? endif;?>
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<div class="categoria-group">
					  	  		<label for="select_categoria" class="col-sm-2 control-label">Categoria</label>
					  	  		<div class="col-sm-6">
					  	  		  	<select class="form-control" id="select_categoria" name="select_categoria">
					  	  		  	  <? if(isset($alterar) && $alterar):?>
									  	<option id="<?= $item[0]['categoria_id'] ?>"><?= $item_categoria[0]['categoria_nome'] ?></option>
									  <? else: ?>
									  	<option id="0">Selecione...</option>
									  <? endif; ?>
									  	<? foreach ($categorias as $key => $value):?>
											<option id="<?= $categorias[$key]['categoria_id']?>"><?= $categorias[$key]['categoria_nome'] ?></option>
										<? endforeach; ?>
									</select>
					  	  		</div>
					  	  	</div>
				  	  	  	<div class="quantidade-group">
				  	  	  		<label for="input_qtde" class="col-sm-2 control-label">Quantidade</label>
				  	  	  		<div class="col-sm-2 input">
						  	  	  	<? if(isset($alterar) && $alterar):?>
									  	<input type="number" class="form-control" id="input_qtde" name="input_qtde" min="1" value="<?= $item[0]['item_qtde'] ?>">
									<? else: ?>
									  	<input type="number" class="form-control" id="input_qtde" name="input_qtde" min="1" value="1">
									<? endif; ?>
						  	  	</div>
				  	  	  	</div>
					  	</div>
					  	<div class="form-group detalhes-group">
					  	  	<label for="area_detalhes" class="col-sm-2 control-label">Detalhes</label>
					  	  	<div class="col-sm-10 input">
					  	  		<? if(isset($alterar) && $alterar):?>
									  	<textarea class="form-control" id="area_detalhes" name="area_detalhes" rows="5"><?= $item[0]['item_detalhes'] ?></textarea>
								<? else: ?>
									  	<textarea class="form-control" id="area_detalhes" name="area_detalhes" rows="5" placeholder="Descreva aqui o máximo de detalhes do seu item"></textarea>
								<? endif; ?> 	
					  	  	</div>
					  	</div>
					  	<div class="form-group fotos-group">
					  		<div class="row">
					  			<label class="col-sm-2 col-xs-2 control-label">Fotos</label>
						  	  	<div class="col-sm-2 col-xs-2">
						  	  		<label for="imagem1">
						  	  	  		<? if(isset($alterar) && $alterar && isset($imagens[0])):?>
						  	  	  			<img class="img img-rounded add-img img-responsive" id="img-1" src="<?= base_url().substr($imagens[0]['imagem_caminho'],2).'/'.$imagens[0]['imagem_nome']?>" alt="Imagem do item" value="<?= base_url().substr($imagens[0]['imagem_caminho'],2).'/'.$imagens[0]['imagem_nome']?>" >
						  	  	  		<? else: ?>
						  	  	  			<img class="img img-rounded add-img img-responsive" id="img-1" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
						  	  	  		<? endif; ?>
						  	  	  	</label>
						  	  	  	<div class="input">
						  	  	  		<input name="imagem1" id="imagem1"  type="file" accept=".gif,.jpg,.png,.jpeg"  style="visibility: hidden">
	
						  	  	  	</div>
						  	  	</div>
						  	  	<div class="col-sm-2 col-xs-2">
						  	  	  	<label for="imagem2">
						  	  	  	<? if(isset($alterar) && $alterar && isset($imagens[1])):?>
						  	  	  		<img class="img img-rounded add-img img-responsive" id="img-2" src="<?= base_url().substr($imagens[1]['imagem_caminho'],2).'/'.$imagens[1]['imagem_nome']?>" alt="Imagem do item" value="<?= base_url().substr($imagens[1]['imagem_caminho'],2).'/'.$imagens[1]['imagem_nome']?>">
						  	  	  	<? else: ?>
						  	  	  		<img class="img img-rounded add-img img-responsive" id="img-2" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
						  	  	  	<? endif; ?>
						  	  	  	</label>
						  	  	  	<input name="imagem2" id="imagem2"  type="file" accept=".gif,.jpg,.png,.jpeg" style="visibility: hidden">
						  	  	</div>
						  	  	<div class="col-sm-2 col-xs-2">
						  	  	  	<label for="imagem3">
						  	  	  	<? if(isset($alterar) && $alterar && isset($imagens[2])):?>
						  	  	  		<img class="img img-rounded add-img img-responsive" id="img-3" src="<?= base_url().substr($imagens[2]['imagem_caminho'],2).'/'.$imagens[2]['imagem_nome']?>" alt="Imagem do item" value="<?= base_url().substr($imagens[2]['imagem_caminho'],2).'/'.$imagens[2]['imagem_nome']?>">
						  	  	  	<? else: ?>
										<img class="img img-rounded add-img img-responsive" id="img-3" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
						  	  	  	<? endif; ?>
						  	  	  	</label>
						  	  	  	<input name="imagem3" id="imagem3"  type="file" accept=".gif,.jpg,.png,.jpeg" style="visibility: hidden">
						  	  	</div>
						  	  	<div class="col-sm-2 col-xs-2">
						  	  	  	<label for="imagem4">
						  	  	  	<? if(isset($alterar) && $alterar && isset($imagens[3]) ):?>
						  	  	  		<img class="img img-rounded add-img img-responsive" id="img-4" src="<?= base_url().substr($imagens[3]['imagem_caminho'],2).'/'.$imagens[3]['imagem_nome']?>" alt="Imagem do item" value="<?= base_url().substr($imagens[3]['imagem_caminho'],2).'/'.$imagens[3]['imagem_nome']?>">
						  	  	  	<? else: ?>
						  	  	  		<img class="img img-rounded add-img img-responsive" id="img-4" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
						  	  	  	<? endif; ?>
						  	  	  	</label>
						  	  	  	<input name="imagem4" id="imagem4"  type="file" accept=".gif,.jpg,.png,.jpeg" style="visibility: hidden">
						  	  	</div>
						  	  	<div class="col-sm-2 col-xs-2">
						  	  	  	<label for="imagem5">
						  	  	  	<? if(isset($alterar) && $alterar && isset($imagens[4]) ):?>
						  	  	  		<img class="img img-rounded add-img img-responsive" id="img-5" src="<?= base_url().substr($imagens[4]['imagem_caminho'],2).'/'.$imagens[4]['imagem_nome']?>" alt="Imagem do item" value="<?= base_url().substr($imagens[4]['imagem_caminho'],2).'/'.$imagens[4]['imagem_nome']?>">
						  	  	  	<? else: ?>
						  	  	  		<img class="img img-rounded add-img img-responsive" id="img-5" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
						  	  	  	<? endif; ?>
						  	  	  	</label>
						  	  	  	<input name="imagem5" id="imagem5"  type="file" accept=".gif,.jpg,.png,.jpeg" style="visibility: hidden">
						  	  	</div>
					  		</div>
					  	</div>
  						<div class="form-group center-block text-center">
  							<? if(isset($alterar) && $alterar):?>
  								<button class="btn btn-warning btn-lg" name="doacaoSubmit" type="submit"><span class="fa fa-pencil-square-o"></span> Alterar</button>
  								<input type="hidden" name="alterar" value="1">
  								<input type="hidden" name="item_id" value="<?= $item[0]['item_id']?>">
  								<input type="hidden" name="old_path" value="<?= $imagens[0]['imagem_caminho'] ?>">
  								<?foreach($imagens as $key => $value){
									echo '<input type="hidden" name="imgOld[]" value="'. $value['imagem_nome']. '">';
								} ?>
  							<? else: ?>
  								<button class="btn btn-danger btn-lg" type="reset"><span class="fa fa-eraser"></span> Limpar</button>
  								<button class="btn btn-success btn-lg" name="doacaoSubmit" type="submit"><span class="fa fa-pencil-square-o"></span> Cadastrar</button>
  							<? endif; ?>
  						</div>
  						<input type="hidden" name="ajax" value="1">
  						<input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>">
					</form>
					
	  			</div>
	  		</div>
	  		<div class="panel-footer text-center">
			</div>
	  	</div>
  	</div>
  </div>
</main>