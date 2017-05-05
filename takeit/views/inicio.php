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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Login</h4>
	      	</div>
	      	<div class="modal-body">
	        	<form class="form-group form-group-lg form-horizontal" id="loginForm" method="post" action="?page=login">
				  	<div class="input-group " id="firstInput">
					    <span class="input-group-addon"><i class="fa fa-user"></i></span>
					    <input id="usuario" type="text" class="form-control" name="usuario" placeholder="Usuário" required 
					    	oninvalid="this.setCustomValidity('O nome do usuário é obrigatório!')" oninput="setCustomValidity('')">
				  	</div>
				  	<div class="input-group">
					    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
					    <input id="password" type="password" class="form-control" name="password" placeholder="Senha" required 
					    	oninvalid="this.setCustomValidity('A senha é obrigatória!')" oninput="setCustomValidity('')">
				  	</div>
				</form>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        	<button type="button" class="btn btn-primary"><span class="fa fa-sign-in"></span> Entrar</button>
	      	</div>
	    </div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	