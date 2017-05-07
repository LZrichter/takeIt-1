<header id="headerLogin">
		<div class="jumbotron text-center">
	  		<h2><i class="fa fa-dashboard"></i> <?= $titulo ?></h2>
	  		<p> <?= $slogan ?></p>
		</div>
</header>

	<main id="mainLogin">
		<div class="container">
			<div class="well col-xs-6 col-xs-offset-3">
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
				  	<br>
				  	<button class="btn btn-primary btn-lg">Entrar <span class="fa fa-sign-in"></span></button>
				</form>
			</div>
		</div>	
	</main>