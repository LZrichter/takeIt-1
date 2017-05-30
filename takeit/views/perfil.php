<ul class="breadcrumb">
  	<li><a href="/painel">Painel</a></li>
  	<li><a href="#">Perfil do Usuário</a></li>
</ul>

<div class="container footer-align" id="main">
	<div class="row">
	  	<div class="panel panel-default">
	  		<div class="panel-heading text-center">
	  			<h2><span class="fa fa-user"></span> Perfil do Usuário</h2>
	  		</div>
	  		<div class="panel-body">
	  			<div class="col-md-8 col-md-offset-2">
	  				<form class="form-group form-horizontal" id="perfilForm">
	  					<div class="form-group foto-perfil">
					  		<label class="col-sm-2 control-label">Foto de Perfil</label>
					  	  	<div class="col-sm-10">
					  	  		<div class="col-sm-4">
					  	  	  		<img class="img-rounded add-img" id="perfil_img" src="<?= base_url()?>/assets/img/painel_perfil.png" alt="Imagem do item">
					  	  	  	</div>
					  	  	  	<div class="col-sm-6">
					  	  	  		<input type="file" name="foto">
					  	  	  	</div>
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_nome" class="col-sm-2 control-label">Nome</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="nome" id="input_nome" placeholder="Nome">
					  	  	</div>
					  	</div>
					  	<div class="form-group" id="div_website"> <!-- TRATAR POR NÍVEL DE USUÁRIO -->
					  	  	<label for="input_website" class="col-sm-2 control-label">Website</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="website" id="input_website" placeholder="website.com.br">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="area_resumo" class="col-sm-2 control-label">Resumo</label>
					  	  	<div class="col-sm-10">
					  	  	  	<textarea class="form-control" id="area_resumo" rows="5" placeholder="Escreva um breve resumo sobre você..."></textarea>
					  	  	</div>
					  	</div>
					  	<div class="form-group text-center">
					  	  	<h4>Dados Pessoais</h4>
			  	  	  		<hr>
					  	</div>
						<div class="form-group" id="div_cpf"> <!-- TRATAR POR NÍVEL DE USUÁRIO -->
					  	  	<label for="input_cpf" class="col-sm-2 control-label">CPF</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control input-d" name="cpf" id="input_cpf" placeholder="000.000.000-00">
					  	  	</div>
					  	</div>
					  	<div class="form-group" id="div_cnpj"> <!-- TRATAR POR NÍVEL DE USUÁRIO -->
					  	  	<label for="input_cnpj" class="col-sm-2 control-label">CNPJ</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="cnpj" id="input_cnpj" placeholder="00.000.000/0000-00">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_email" class="col-sm-2 control-label">Email</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="email" class="form-control" name="email" id="input_email" placeholder="email@email.com">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_senha" class="col-sm-2 control-label">Senha</label>
					  	  	<div class="col-sm-4">
					  	  	  	<input type="password" class="form-control" name="senha" id="input_senha" placeholder="**********">
					  	  	</div>
				  	  	  	<label for="input_confirma" class="col-sm-2 control-label">Confirmação</label>
				  	  	  	<div class="col-sm-4">
					  	  	  	<input type="password" class="form-control" name="confirmacao" id="input_confirma" placeholder="Confirme sua Senha">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_endereco" class="col-sm-2 control-label">Endereço</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="endereco" id="input_endereco" placeholder="Rua Nome de Exemplo">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_bairro" class="col-sm-2 control-label">Bairro</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="bairro" id="input_bairro" placeholder="Bairro de Exemplo">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_numero" class="col-sm-2 control-label">Número</label>
					  	  	<div class="col-sm-4">
					  	  	  	<input type="text" class="form-control" name="numero" id="input_numero" placeholder="1001">
					  	  	</div>
				  	  	  	<label for="input_complemento" class="col-sm-2 control-label">Complemento</label>
				  	  	  	<div class="col-sm-4">
					  	  	  	<input type="text" class="form-control" name="complemento" id="input_complemento" placeholder="Apt 101">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="select_estado" class="col-sm-2 control-label">Estado</label>
					  	  	<div class="col-sm-4">
					  	  	  	<select class="form-control" name="estado" id="select_estado">
								  	<? if(isset($estados)){ ?>
										<option selected="true" disabled="true" style="display: none;">Selecione seu estado</option>

										<? foreach ($estados as $n => $val){ ?>
											<option value="<?= $val["id"]; ?>"><?= $val["uf"]; ?></option>
										<? }
									}else{ ?>
										<option selected="true" disabled="true">Ocorreu um erro, tente recarregar a página!</option>
									<? } ?>
								</select>
					  	  	</div>
				  	  	  	<label for="select_cidade" class="col-sm-2 control-label">Cidade</label>
				  	  	  	<div class="col-sm-4">
					  	  	  	<select class="form-control" name="cidade" id="select_cidade" disabled="true">
					  	  	  		<option selected="true" disabled="true" title="Selecione seu estado">Selecione o estado.</option>
								</select>
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_telefone" class="col-sm-2 control-label">Telefone</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="telefone" id="input_telefone" placeholder="(XX) 00000-0000">
					  	  	</div>
					  	</div>
					  	<div class="form-group" id="div_mensagem" style="display: none;">
					  	  	<div class="col-sm-10 col-sm-offset-2 text-center">
					  	  	  	<div id="mensagem"></div>
					  	  	</div>
					  	</div>
					  	<div class="form-group text-center">  <!-- TRATAR POR NÍVEL DE USUÁRIO -->
					  	  	<h4>Categorias de Interesse</h4>
			  	  	  		<hr>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="select_categoria" class="col-sm-2 control-label">Categoria</label>
					  	  	<div class="col-sm-9">
					  	  	  	<select class="form-control" id="select_categoria">
								  <option>Selecione...</option>
								  <option>Roupas</option>
								  <option>Sapatos</option>
								  <option>Móveis</option>
								  <option>Eletrodomésticos</option>
								</select>
					  	  	</div>
				  	  	  	<div class="col-sm-1">
					  	  	  	<button type="button" class="btn btn-primary" onclick="alert('Adicionar outra categoria de interesse!');"><span class="fa fa-plus"></span></button>
					  	  	</div>
					  	</div>
					</form>
	  			</div>
	  		</div>
	  		<div class="panel-footer text-center">
	  			<button class="btn btn-danger btn-lg" type="button"><span class="fa fa-eraser"></span> Limpar</button>

	  			<button class="btn btn-success btn-lg" type="button"><span class="fa fa-save"></span> Salvar</button>
	  		</div>
	  	</div>
  	</div>
</div>