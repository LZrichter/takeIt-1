function interesse(OBJ, item_id){
	if(OBJ.value=="adicionar"){
		$.ajax({
			url: 'Doacoes/interesse',
			type: 'POST',
			data: { item_id: item_id,
					acao: 	 "adicionar" },
			dataType: "json",
			success: function(data){
				if(data["tipo"] == "erro"){
					mensagem(data["tipo"], data["msg"], "mensagem");
					$("#div_mensagem").show();
				}else{
					OBJ.className = "btn btn-primary btn-sm";
					OBJ.innerHTML = "<i class='fa fa-minus-circle'></i> Remover interesse";
					OBJ.value 	  = "remover";
				}
			},
			error: function(data){
				mensagem("erro", "Ocorreu um problema. Por favor, tente mais tarde ou contate o suporte através do e-mail: <b>suporte@takeit.com.br</b>", "mensagem");
			}
		});
	}else{
		$.ajax({
			url: 'Doacoes/interesse',
			type: 'POST',
			data: { item_id: item_id,
					acao: 	 "remover" },
			dataType: "json",
			success: function(data){
				if(data["tipo"] == "erro"){
					mensagem(data["tipo"], data["msg"], "mensagem");
					$("#div_mensagem").show();
				}else{
					OBJ.className = "btn btn-danger btn-sm";
					OBJ.innerHTML = "<i class='fa fa-heart'></i> Manifestar interesse";
					OBJ.value 	  = "a";
				}
			},
			error: function(data){
				mensagem("erro", "Ocorreu um problema. Por favor, tente mais tarde ou contate o suporte através do e-mail: <b>suporte@takeit.com.br</b>", "mensagem");
			}
		});
	}
}