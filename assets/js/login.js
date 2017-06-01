$("#loginForm").on("submit", function(e){
    e.preventDefault();

    $("#btnLogin").val('<i class="fa fa-cog fa-spin fa-1x fa-fw"></i> Entrando...');
    $("#btnLogin").prop("disabled", true);

    if($("#inputEmail").val().length <= 0 || $("#inputPassword").val().length <= 0){
		$("#btnLogin").val('Entrar <span class="fa fa-sign-in">');
		$("#btnLogin").prop("disabled", false);

    	mensagem("erro", "E-mail e senha devem ser preenchidos!.", "mensagem");
		$("#div_mensagem").show();
    }else{
    	$.ajax({
			url: 'login/entrar',
			type: 'POST',
			data: $("#loginForm").serialize() + "&ajax=1",
			dataType: "json",
			success: function(data){
				$("#btnLogin").val('Entrar <span class="fa fa-sign-in">');
				$("#btnLogin").prop("disabled", false);

				if(data["tipo"] == "erro"){
					$("#inputPassword").val("");

					mensagem(data["tipo"], data["msg"], "mensagem");
					$("#div_mensagem").show();
				}else window.location.href = "/doacoes";
			},
			error: function(data){
				console.log(data);
				$("#btnLogin").val('Entrar <span class="fa fa-sign-in">');
				$("#btnLogin").prop("disabled", false);

				mensagem("erro", "Ocorreu um problema na hora de entrar. Por favor, mude os dados inseridos ou tente mais tarde.", "mensagem");
				$("#div_mensagem").show();
			},
			finally: function(data){
				$("#btnLogin").val('Entrar <span class="fa fa-sign-in">');
				$("#btnLogin").prop("disabled", false);
			}
		});
    }

	$("#btnLogin").val('Entrar <span class="fa fa-sign-in">');
	$("#btnLogin").prop("disabled", false);
});