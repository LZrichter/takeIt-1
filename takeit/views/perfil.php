<ul class="breadcrumb">
  	<li><a href="/painel">Painel</a></li>
  	<li><a href="#">Dados da Conta</a></li>
</ul>

<div class="container footer-align" id="main">
	<div class="row">
	  	<div class="panel panel-default">
	  		<div class="panel-heading text-center">
	  			<h2><span class="fa fa-user"></span> Dados da Conta do Usuário</h2>
	  		</div>
	  		<div class="panel-body">
	  		<?//var_dump($usuario)?>
	  			<div class="col-md-8 col-md-offset-2">
	  				<form class="form-group form-horizontal" enctype="multipart/form-data" id="form_perfil" method="POST">
	  					<div class="form-group foto-perfil">
					  		<label class="col-sm-2 control-label">Foto de Perfil</label>
					  	  	<div class="col-sm-10">
					  	  		<div class="col-sm-4 img-rounded">
					  	  	  		<img id="perfil_img" src="<?=($usuario['imagem_id'])?base_url().$usuario['imagem_caminho'].'/'.$usuario['imagem_nome']:base_url().'/assets/img/painel_perfil.png'?>" alt="Foto do usuário">
					  	  	  	</div>
					  	  	  	<div class="col-sm-6">
					  	  	  		<input type="file" name="foto" id="file_foto" accept=".gif,.jpg,.png,.jpeg">
					  	  	  		<input type="hidden" name="old_foto" id="input_old_foto" value="<?=($usuario['imagem_id'])?$usuario['imagem_nome']:''?>">
					  	  	  	</div>
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_nome" class="col-sm-2 control-label">Nome</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="nome" id="input_nome" placeholder="Nome" value="<?=$usuario['nome'];?>">
					  	  	</div>
					  	</div>
					  	<? if($usuario['nivel']=='Instituição'): ?>
						  	<div class="form-group" id="div_website">
						  	  	<label for="input_website" class="col-sm-2 control-label">Website</label>
						  	  	<div class="col-sm-10">
						  	  	  	<input type="text" class="form-control" name="website" id="input_website" placeholder="website.com.br" value="<?=$usuario['instituicao_site']?>">
						  	  	</div>
						  	</div>
						<? endif; ?>
					  	<div class="form-group">
					  	  	<label for="area_resumo" class="col-sm-2 control-label">Resumo</label>
					  	  	<div class="col-sm-10">
					  	  	  	<textarea class="form-control" name="resumo" id="area_resumo" rows="5" placeholder="Escreva um breve resumo sobre você..."><?=$usuario['resumo'];?></textarea>
					  	  	</div>
					  	</div>
					  	<div class="form-group text-center">
					  	  	<h4>Dados Pessoais</h4>
			  	  	  		<hr>
					  	</div>
					  	<? if($usuario['nivel']!='Instituição'): ?>
							<div class="form-group" id="div_cpf">
						  	  	<label for="input_cpf" class="col-sm-2 control-label">CPF</label>
						  	  	<div class="col-sm-10">
						  	  	  	<input type="text" class="form-control input-d" name="cpf" id="input_cpf" placeholder="000.000.000-00" value="<?=$usuario['pessoa_cpf'];?>">
						  	  	</div>
						  	</div>
						<? else: ?>
						  	<div class="form-group" id="div_cnpj">
						  	  	<label for="input_cnpj" class="col-sm-2 control-label">CNPJ</label>
						  	  	<div class="col-sm-10">
						  	  	  	<input type="text" class="form-control" name="cnpj" id="input_cnpj" placeholder="00.000.000/0000-00" value="<?=$usuario['instituicao_cnpj'];?>">
						  	  	</div>
						  	</div>
						<? endif; ?>
					  	<div class="form-group">
					  	  	<label for="input_email" class="col-sm-2 control-label">Email</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="email" class="form-control" name="email" id="input_email" placeholder="email@email.com" value="<?=$usuario['email'];?>">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_senha" class="col-sm-2 control-label">Senha</label>
					  	  	<div class="col-sm-4">
					  	  	  	<input type="password" class="form-control" name="senha" id="input_senha" placeholder="***************" value="***************">
					  	  	</div>
				  	  	  	<label for="input_confirma" class="col-sm-2 control-label">Confirmação</label>
				  	  	  	<div class="col-sm-4">
					  	  	  	<input type="password" class="form-control" name="confirmacao" id="input_confirma" placeholder="Confirme sua Senha" value="***************">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_endereco" class="col-sm-2 control-label">Endereço</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="endereco" id="input_endereco" placeholder="Rua Nome de Exemplo" value="<?=$usuario['endereco'];?>">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_bairro" class="col-sm-2 control-label">Bairro</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="bairro" id="input_bairro" placeholder="Bairro de Exemplo" value="<?=$usuario['bairro'];?>">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_numero" class="col-sm-2 control-label">Número</label>
					  	  	<div class="col-sm-4">
					  	  	  	<input type="text" class="form-control" name="numero" id="input_numero" placeholder="1001" value="<?=$usuario['numero'];?>">
					  	  	</div>
				  	  	  	<label for="input_complemento" class="col-sm-2 control-label">Complemento</label>
				  	  	  	<div class="col-sm-4">
					  	  	  	<input type="text" class="form-control" name="complemento" id="input_complemento" placeholder="Apt 101" value="<?=$usuario['complemento'];?>">
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="select_estado" class="col-sm-2 control-label">Estado</label>
					  	  	<div class="col-sm-4">
					  	  	  	<select class="form-control" name="estado" id="select_estado">
								  	<? if(isset($estados)){ ?>
										<? foreach ($estados as $n => $val){ ?>
											<option value="<?= $val['id']; ?>" <?=($val['uf']==$usuario['estado_uf'])?'selected':''?>><?= $val['uf']; ?></option>
										<? }
									}else{ ?>
										<option selected="true" disabled="true">Ocorreu um erro, tente recarregar a página!</option>
									<? } ?>
								</select>
					  	  	</div>
				  	  	  	<label for="select_cidade" class="col-sm-2 control-label">Cidade</label>
				  	  	  	<div class="col-sm-4">
					  	  	  	<select class="form-control" name="cidade" id="select_cidade">
					  	  	  		<? if(isset($cidades)){ ?>
										<? foreach ($cidades as $n => $val){ ?>
											<option value="<?= $val['id']; ?>" <?=($val['id']==$usuario['cidade_id'])?'selected':''?>><?= $val['nome']; ?></option>
										<? }
									}else{ ?>
										<option selected="true" disabled="true">Ocorreu um erro, tente recarregar a página!</option>
									<? } ?>
					  	  	  		<!-- <option selected="true" disabled="true" title="Selecione seu estado">Selecione o estado.</option> -->
								</select>
					  	  	</div>
					  	</div>
					  	<div class="form-group">
					  	  	<label for="input_telefone" class="col-sm-2 control-label">Telefone</label>
					  	  	<div class="col-sm-10">
					  	  	  	<input type="text" class="form-control" name="telefone" id="input_telefone" placeholder="(XX) 00000-0000" value="<?=$usuario['telefone'];?>">
					  	  	</div>
					  	</div>
					  	<div class="form-group" id="div_mensagem" style="display: none;">
					  	  	<div class="col-sm-10 col-sm-offset-2 text-center">
					  	  	  	<div id="mensagem"></div>
					  	  	</div>
					  	</div>
  						<input type="hidden" name="user_nivel" id="user_nivel"" value="<?= $usuario['nivel'];?>">
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