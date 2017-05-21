<main id="mainCadastro">
	<div class="container">
		<div class="col-xs-6 col-xs-offset-3">
		 	<form class="form-group form-horizontal" id="cadastroForm" method="post" action="?page=cadastro">
		 		<h2>Cadastre-se</h2>
	      		<div class="form-group">
			  	  	<label class="col-sm-2 control-label">Tipo</label>
			  	  	<div class="col-sm-10">
			  	  	  	<label class="radio-inline">
						  	<input type="radio" name="radio_tipo" id="radio_pessoa" value="option1"> Pessoa
						</label>
						<label class="radio-inline">
						  	<input type="radio" name="radio_tipo" id="radio_instituicao" value="option2"> Instituição
						</label>
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_nome" class="col-sm-2 control-label">Nome</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" id="input_nome" placeholder="Nome">
			  	  	</div>
			  	</div>
				<div class="form-group">
			  	  	<label for="input_cpf" class="col-sm-2 control-label">CPF</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" id="input_cpf" placeholder="000.000.000-00">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_email" class="col-sm-2 control-label">Email</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="email" class="form-control" id="input_email" placeholder="email@email.com">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_senha" class="col-sm-2 control-label">Senha</label>
			  	  	<div class="col-sm-4">
			  	  	  	<input type="password" class="form-control" id="input_senha" placeholder="**********">
			  	  	</div>
		  	  	  	<label for="input_confirma" class="col-sm-2 control-label">Confirmação</label>
		  	  	  	<div class="col-sm-4">
			  	  	  	<input type="password" class="form-control" id="input_confirma" placeholder="Confirme sua Senha">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_endereco" class="col-sm-2 control-label">Endereço</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" id="input_endereco" placeholder="Rua Comissario Justo">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_bairro" class="col-sm-2 control-label">Bairro</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" id="input_bairro" placeholder="Centro">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_numero" class="col-sm-2 control-label">Número</label>
			  	  	<div class="col-sm-4">
			  	  	  	<input type="text" class="form-control" id="input_numero" placeholder="1482">
			  	  	</div>
		  	  	  	<label for="input_complemento" class="col-sm-2 control-label">Complement.</label>
		  	  	  	<div class="col-sm-4">
			  	  	  	<input type="text" class="form-control" id="input_complemento" placeholder="Apt 101">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="select_estado" class="col-sm-2 control-label">Estado</label>
			  	  	<div class="col-sm-4">
			  	  	  	<select class="form-control" id="select_estado">
						  <option>RJ</option>
						  <option>RS</option>
						  <option>RN</option>
						  <option>SP</option>
						</select>
			  	  	</div>
		  	  	  	<label for="select_cidade" class="col-sm-2 control-label">Cidade</label>
		  	  	  	<div class="col-sm-4">
			  	  	  	<select class="form-control" id="select_cidade">
						  <option>Mata</option>
						  <option>Santa Maria</option>
						  <option>Santo Cristo</option>
						  <option>São Valério</option>
						</select>
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<label for="input_telefone" class="col-sm-2 control-label">Telefone</label>
			  	  	<div class="col-sm-10">
			  	  	  	<input type="text" class="form-control" id="input_telefone" placeholder="(XX) 00000-0000">
			  	  	</div>
			  	</div>
			  	<div class="form-group">
			  	  	<div class="col-sm-offset-2 col-sm-10">
			  	  	  	<div class="checkbox">
			  	  	  	  	<label> <input type="checkbox" id="input_licenca"> Concordo com os termos da <a target="_blank" href="cadastro/licenca_uso">Licença de Uso.</a></label>
			  	  	  	</div>
			  	  	</div>
			  	</div>
			  	<div class="form-group text-right">
			  		<div class="col-sm-offset-6 col-sm-6">
	        			<button type="submit" class="btn btn-success"><span class="fa fa-pencil-square-o"></span> Cadastrar</button>
	        		</div>
        		</div>
			</form>
		</div>
	</div>	
</main>