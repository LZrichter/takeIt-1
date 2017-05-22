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
	  				<form class="form-group form-horizontal" id="doacaoForm" method="post" 	action="?page=doacoes">
					  	<div class="form-group">
					  	  	<label for="input_descricao" class="col-sm-2 control-label">Descrição</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" id="input_descricao" placeholder="Descrição do item">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="select_categoria" class="col-sm-2 control-label">Categoria</label>
					  	  	<div class="col-sm-6">
					  	  	  	<select class="form-control" id="select_categoria">
								  <option>Selecione...</option>
								  <option>Roupas</option>
								  <option>Sapatos</option>
								  <option>Móveis</option>
								  <option>Eletrodomésticos</option>
								</select>
					  	  	</div>
				  	  	  	<label for="input_qtde" class="col-sm-2 control-label">Quantidade</label>
				  	  	  	<div class="col-sm-2">
					  	  	  	<input type="number" class="form-control" id="input_qtde" placeholder="0">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="area_detalhes" class="col-sm-2 control-label">Detalhes do Item</label>
					  	  	<div class="col-sm-10">
					  	  	  	<textarea class="form-control" id="area_detalhes" rows="5" placeholder="Descreva aqui o máximo de detalhes do seu item"></textarea>
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  		<label class="col-sm-2 control-label">Fotos do item</label>
					  	  	<div class="col-sm-2">
					  	  	  	<img class="img-rounded add-img" id="img-1" onclick="alert("Adicionar")" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	</div>
					  	  	<div class="col-sm-2">
					  	  	  	<img class="img-rounded add-img" id="img-2" onclick="alert("Adicionar")" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	</div>
					  	  	<div class="col-sm-2">
					  	  	  	<img class="img-rounded add-img" id="img-3" onclick="alert("Adicionar")" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	</div>
					  	  	<div class="col-sm-2">
					  	  	  	<img class="img-rounded add-img" id="img-4" onclick="alert("Adicionar")" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	</div>
					  	  	<div class="col-sm-2">
					  	  	  	<img class="img-rounded add-img" id="img-5" onclick="alert("Adicionar")" src="<?= base_url()?>/assets/img/add-img.png" alt="Imagem do item">
					  	  	</div>
					  	</div>
					</form>
	  			</div>
	  		</div>
	  		<div class="panel-footer text-center">
	  			<button class="btn btn-danger btn-lg" type="button"><span class="fa fa-eraser"></span> Limpar</button>

	  			<button class="btn btn-success btn-lg" type="button"><span class="fa fa-pencil-square-o"></span> Cadastrar</button>
	  		</div>
	  	</div>
  	</div>
  </div>
</main>