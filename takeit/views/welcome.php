<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!'); ?>


<div id="container">
	<center>
		<h1>Ajude quem precisa, doando o que você não precisa</h1>
	</center>

	<center>
		<h2>
			<?= (isset($teste) ? $teste : "Erro no teste"); ?>
		</h2>
	</center>
</div>

<!-- MODAL LOGIN -->
<div class="modal fade" id="modal_login" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h3 class="modal-title">Login</h3>
	      	</div>
	      	<div class="modal-body">
		      	<form method="post" action="?page=login">
				  	<div class="form-group">
				  	  	<label for="usuario">E-mail</label>
				  	  	<input type="email" class="form-control" id="usuario" required placeholder="Email">
				  	</div>
				  	<div class="form-group">
				  	  	<label for="password">Senha</label>
				  	  	<input type="password" class="form-control" id="password" required placeholder="Password">
				  	</div>
				  	<br/>
				  	<div class="form-group text-right">
					  	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        		<button type="submit" class="btn btn-primary"><span class="fa fa-sign-in"></span> Entrar</button>
		        	</div>
				</form>
	      	</div>
	    </div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- MODAL CADASTRO -->
<div class="modal fade" id="modal_cadastro" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h3 class="modal-title">Cadastro</h3>
	      	</div>
	      	<div class="modal-body">
		      	<form class="form-horizontal" action="?page=cadastro">
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
			  	  	  	<label for="input_complemento" class="col-sm-2 control-label">Complemento</label>
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
				  	  	  	  	<label> <input type="checkbox" id="input_licenca"> Concordo com os termos da <a href="#">Licença de Uso.</a></label>
				  	  	  	</div>
				  	  	</div>
				  	</div>
				  	<div class="form-group text-right">
				  		<div class="col-sm-offset-6 col-sm-6">
					  		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        			<button type="submit" class="btn btn-success"><span class="fa fa-pencil-square-o"></span> Cadastrar</button>
		        		</div>
	        		</div>
				</form>
	      	</div>
	    </div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	