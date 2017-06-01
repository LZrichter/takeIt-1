<main id="mainLogin" class="footer-align">
	<div class="container">
      	<form class="form-signin" id="loginForm">
            <h2 class="text-center">Acesse sua conta</h2>
            <hr>

	        <div class="form-group">
                <label for="inputEmail">E-mail</label>
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="E-mail" required autofocus oninvalid="this.setCustomValidity('O email é obrigatório e deve estar no formado adequado!')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="inputPassword">Senha</label>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Senha" required oninvalid="this.setCustomValidity('A senha é obrigatória!')" oninput="setCustomValidity('')">
                <a href="#">Esqueceu sua senha?</a>
            </div>
            <div class="form-group" id="div_mensagem" style="display: none;">
                <div id="mensagem"></div>
            </div>
	        <!-- <div class="checkbox"><label><input type="checkbox" value="remember-me"> Remember me</label></div> -->
	        <button id="btnLogin" class="btn btn-lg btn-primary btn-block" type="submit">Entrar <span class="fa fa-sign-in"></span></button>
	    </form>
	</div>	
</main>