<main id="mainLogin" class="footer-align">
	<div class="container">
      	<form class="form-signin" id="loginForm" method="post" action="?page=login">
            <h2 class="text-center">Acesse sua conta</h2>

	        <div class="form-group">
                <label for="usuario">E-mail</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="E-mail" required autofocus oninvalid="this.setCustomValidity('O nome do usuário é obrigatório!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Senha" required oninvalid="this.setCustomValidity('A senha é obrigatória!')" oninput="setCustomValidity('')">
                <a href="#">Esqueceu sua senha?</a>
            </div>
	        <!-- <div class="checkbox"><label><input type="checkbox" value="remember-me"> Remember me</label></div> -->
	        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar <span class="fa fa-sign-in"></span></button>
	    </form>
	</div>	
</main>