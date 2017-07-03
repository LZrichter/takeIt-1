<ul class="breadcrumb">
  <li><a href="/doacoes">Home</a></li>
  <li><a href="#">Doações</a></li>
</ul>

<div class="container container-fluid procurando-algo">
	<div class="row text-center">
		<form action="doacoes" method="post"><div class="col-xs-12 col-sm-7 col-md-7 col-md-offset-1">
			<div class="input-group">
				<input type="hidden" name="search_param" value="all" id="search_param">
				<input type="text" class="form-control input-lg" name="busca" placeholder="Procurando por algo?">
				<span class="input-group-btn">
					<button class="btn btn-primary btn-lg" type="submit"><span class="fa fa-search"></span> Pesquisar</button>
				</span>
			</div>
		</div></form>
		<div class="col-xs-12 col-sm-5 col-md-3">
			<div id="filtro-pesquisa" class="btn btn-info btn-lg" ><span class="fa fa-filter"></span> Quer filtrar sua pesquisa?</div>
		</div>
	</div>
	<? if($busca != ""){
		echo "<div class='row text-center'>
			<div class='col-xs-12 col-sm-7 col-md-7 col-md-offset-1'>
				<div class='input-group'><p>Exibindo resultados para ".$busca."</p></div>
			</div>
		</div>";
	} ?>
</div>
<div class="container-fluid footer-align">
	<div class="bloco-doacoes text-center center-block">
		<!-- Mensagem com os erros  -->
		<div class="form-group" id="div_mensagem">
			<div id="mensagem"></div>
		</div>
		<!-- /Mensagem com os erros -->

		<? foreach ($itens as $key => $value): ?>
			<? if($key === "paginas_qtde") continue; ?>
				<div class="col-item"><!-- Cada Doação -->
					<div class="photo"> 
						<a href="doacoes/item/<?= $itens[$key]['item_id'];?>" alt="Veja todas as fotos da doação.">
							<img src="<?= base_url().substr($itens[$key]['imagem_caminho'],2).'/'.$itens[$key]['imagem_nome'];?>" class="img-thumbnail img-responsive" alt="Foto do produto"  />
							<div class="overlay">
								<div class="text"><span class="fa fa-plus"></span> Ver Produto</div>
							</div>
						</a>
					</div>
					<div class="info">
						<div class="titulo text-center">
							<h5><?=$itens[$key]['item_descricao'];?></h5>
						</div>
						<div class="button text-center">
								<? if($itens[$key]['interessado']): ?>
									<button type="button" class="btn btn-primary btn-sm" value="remover" onclick="interesse(this,<?=$itens[$key]['item_id']?>);">
										<i class="fa fa-minus-circle"></i> Remover interesse
									</button>
								<? else : ?>
									<button type="button" class="btn btn-danger btn-sm" value="adicionar" onclick="interesse(this,<?=$itens[$key]['item_id']?>);">
										<i class="fa fa-heart"></i> Manifestar interesse
									</button>
								<? endif; ?>
						</div>
						<div class="clearfix">
						</div>
					</div>
				</div>
			
		<? endforeach; ?>
		<br />
	 	<ul class="pagination">
	 		<? for($count = 1; $count <= $itens["paginas_qtde"]; $count++){ ?>
	 			<?php if ($this->session->userdata['indice'] == $count) { ?>
	 				<li class="active"><a href="doacoes/index/<?= $count ?>"><?=$count?></a></li>
	 			<?php } else { ?>
	 				<li><a href="<?= base_url() ?>doacoes/index/<?= $count ?>"><?=$count?></a></li>
	 			<?php } ?>
	 		<? } ?>
	 	</ul>
	</div>
</div><!-- bloco das doações -->