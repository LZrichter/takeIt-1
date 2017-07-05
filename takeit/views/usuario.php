<ul class="breadcrumb">
  	<li><a href="/doacoes">Home</a></li>
  	<li><a href="#">Perfil de Usuário</a></li>
</ul>

<div class="container footer-align" id="main">
	<div class="row" id="mainUser">
	  	<div class="panel panel-default">
	  		<div class="panel-heading text-center">
	  			<h2><span class="fa fa-archive"></span> Perfil de usuário</h2>
	  		</div>
	  		<div class="panel-body info-perfil">
	  			<div class="row">
		  			<div class="col-sm-6 col-md-6 col-lg-4 text-center">
		  				<img id="info-img" src="<?=($usuario['imagem_id'])?base_url().$usuario['imagem_caminho'].'/'.$usuario['imagem_nome']:base_url().'/assets/img/painel_perfil.png'?>" alt="Foto do usuário">
		  			</div>
					<div class="col-sm-6 col-md-6 col-lg-8">
						<div class="center-block text-left">
							<p><strong>Nome: </strong><?= $usuario["nome"] ?></p>
							<p><strong>Resumo: </strong><?= $usuario["resumo"] ?></p>
							<p><strong>Cidade/UF: </strong><?= $usuario['cidade_nome'].' / '.$usuario['estado_uf'] ?></p>
							<? if($usuario['nivel']=='Instituição'): ?>
						  	  	<p><strong>Endereço: </strong><?= $usuario["endereco"] ?></p>
						  	  	<p>
						  	  		<strong>Número: </strong><?= $usuario["numero"] ?> <?= $usuario["complemento"] ?>
						  	  		<strong>Bairro: </strong><?= $usuario["bairro"] ?>
						  	  	</p>
						  	  	<p><strong><a href="http://<?= $usuario["instituicao_site"] ?>" target="_blank"><?= $usuario["instituicao_site"] ?></a></strong></p>
						  	  	<!-- Categorias da instituição -->
						  	  	<p><strong>Categorias de Interesse:</strong></p>
							  	<div class="form-group">
							  		<? if(isset($categorias_interesse) && count($categorias_interesse)>0){
							  			echo "<ul>";
								  		foreach ($categorias_interesse as $indice => $id_cat) {
						  	  				echo " <li>".$categorias[$id_cat]['categoria_nome'].";</li>";
										} 
										echo "</ul>";
								  	} ?>
							  	</div>
							<? endif; ?>
						</div>
					</div>
				</div>
				<? if($usuario['nivel']=='Pessoa'): ?>
					<div class="row">
						<div class="col-md-10 col-md-offset-1 text-center" id="agradecimentos">
							<hr>
							<h4><strong>Agradecimentos para o usuario</strong></h4>
						</div>
					</div>
				<? endif; ?>
	  		</div>
	  		<div class="panel-footer text-center">
	  			<button id="btn-reportar" class="btn btn-danger" data-toggle="popover" ><span class="fa fa-flag"></span> Reportar Usuário</button>
	  		</div>
	  		<div id="popover-content" style="display: none; width: 100%" >
			    <div class="container" style=" width: 100% ">
				    <div class="row" style="padding-top: 10px;">
				        <label id="sample" class="text-center">
				            <form id="mainForm" class="form-group" name="mainForm" method="post">
							    <p>
							        <textarea class="form-control" id="denuncia_text" rows="5" cols="20" name="denuncia_text" placeholder="Digite aqui o motivo de sua reclamação..." required ></textarea>
							    </p>
							    <p>
							    	<input type="hidden" name="item_vacilao" value=""/>
							        <input type="hidden" name="usuario_vacilao" value="<?= $usuario["id"] ?>"/>
							        <input type="hidden" name="usuario_x9" value="<?= $this->session->userdata('user_id') ?>"/>
							        <input class="btn btn-danger btn-denunciar" type="submit" name="Submit" value="Denunciar" />
							    </p>
							</form>
				        </label>
				    </div>
			    </div> 
			</div>
	  	</div>
  	</div>
  </div>
</main>

<!-- Modal de mensagem -->
<div class="modal fade" id="mensagem-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel"></h4>
      </div>
      <div class="modal-body" id="modalMsg">

      </div>
      <div class="modal-footer">
 		<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div> <!-- /.modal -->