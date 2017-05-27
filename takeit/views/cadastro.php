<main id="mainCadastro" class="footer-align">
	<div class="container">
		<div class="col-xs-8 col-xs-offset-2">
		 	<form class="form-group form-horizontal" id="cadastroForm">
	      		<div class="form-group">
			  	  	<div class="col-sm-11 col-sm-offset-1 text-center">
			  	  		<h2>Cadastre-se</h2> <hr>	
			  	  	</div>
	      		</div>
	      		<div class="form-group">
	      			<ul class="nav nav-tabs nav-justified">
					    <li id="li_pessoa" class="active">
					    	<a id="tab_pessoa" data-toggle="tab" href="#"><i class="fa fa-user" aria-hidden="true"></i> Pessoa</a>
					    	<input type="radio" id="radio_pessoa" name="tipo_usuario" value="Pessoa" checked="TRUE">
					    </li>
					    <li id="li_instituicao">
					    	<a id="tab_instituicao" data-toggle="tab" href="#"><i class="fa fa-building" aria-hidden="true"></i> Instituição</a>
					    	<input type="radio" id="radio_instituicao" name="tipo_usuario" value="Instituição">
					    </li>
				  	</ul>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_nome" class="col-sm-2 control-label">* Nome</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" name="nome" id="input_nome" placeholder="Nome">
			  	  	</div>
			  	</div>
				<div class="form-group" id="div_cpf">
			  	  	<label for="input_cpf" class="col-sm-2 control-label">* CPF</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control input-d" name="cpf" id="input_cpf" placeholder="000.000.000-00">
			  	  	</div>
			  	</div>
			  	<div class="form-group" id="div_cnpj">
			  	  	<label for="input_cnpj" class="col-sm-2 control-label">* CNPJ</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" name="cnpj" id="input_cnpj" placeholder="00.000.000/0000-00">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_email" class="col-sm-2 control-label">* Email</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="email" class="form-control" name="email" id="input_email" placeholder="email@email.com">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_senha" class="col-sm-2 control-label">* Senha</label>
			  	  	<div class="col-sm-4">
			  	  	  	<input type="password" class="form-control" name="senha" id="input_senha" placeholder="**********">
			  	  	</div>
		  	  	  	<label for="input_confirma" class="col-sm-2 control-label">* Confirmação</label>
		  	  	  	<div class="col-sm-4">
			  	  	  	<input type="password" class="form-control" name="confirmacao" id="input_confirma" placeholder="Confirme sua Senha">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_endereco" class="col-sm-2 control-label">Endereço</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" name="endereco" id="input_endereco" placeholder="Rua Comissario Justo">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_bairro" class="col-sm-2 control-label">Bairro</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" name="bairro" id="input_bairro" placeholder="Centro">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_numero" class="col-sm-2 control-label">Número</label>
			  	  	<div class="col-sm-4">
			  	  	  	<input type="text" class="form-control" name="numero" id="input_numero" placeholder="1482">
			  	  	</div>
		  	  	  	<label for="input_complemento" class="col-sm-2 control-label">Complemento</label>
		  	  	  	<div class="col-sm-4">
			  	  	  	<input type="text" class="form-control" name="complemento" id="input_complemento" placeholder="Apt 101">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="select_estado" class="col-sm-2 control-label">* Estado</label>
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
		  	  	  	<label for="select_cidade" class="col-sm-2 control-label">* Cidade</label>
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
			  	<div class="form-group" id="div_website">
			  	  	<label for="input_website" class="col-sm-2 control-label">Website</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" name="website" id="input_website" placeholder="website.com.br">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<div class="col-sm-offset-2 col-sm-6">
			  	  	  	<div class="checkbox">
			  	  	  	  	<label> <input type="checkbox" name="termos" id="input_licenca" value="Sim">* Concordo com os termos da <a target="_blank" href="licenca-de-uso">Licença de Uso.</a></label>
			  	  	  	</div>
			  	  	</div>
			  	  	<div class="col-sm-4 text-right">
			  	  	  	<small><strong>* Campos obrigatórios.</strong></small>
			  	  	</div>
			  	</div>
			  	<div class="form-group" id="div_mensagem" style="display: none;">
			  	  	<div class="col-sm-10 col-sm-offset-2 text-center">
			  	  	  	<div id="mensagem"></div>
			  	  	</div>
			  	</div>
			  	<div class="form-group text-right">
			  		<div class="col-sm-offset-6 col-sm-6">
	        			<button type="submit" class="btn btn-success" id="btnSend">
	        				<span class="fa fa-pencil-square-o"></span> Cadastrar
        				</button>
	        		</div>
        		</div>
			</form>
			<input type="hidden" id="basePath" value="<?= base_url(); ?>">
		</div>
	</div>	
</main>