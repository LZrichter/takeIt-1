$(document).ready(function(){
    $('[data-toggle="popover"]').popover({
    	container: "body",
    	title: "Motivo da Denúncia",
    	html: true,
    	content : function() {
        	return $('#popover-content').html();
    	},
		placement: "top"
    });
});

$(document).on('submit', '#mainForm', function(e){
	e.preventDefault();
	var item_vacilao    = $('input[name=item_vacilao]').val();
	var usuario_vacilao = $('input[name=usuario_vacilao]').val();
	var usuario_x9      = $('input[name=usuario_x9]').val();
	var denuncia_text   = $(this).find('textarea[name=denuncia_text]').val();
	$('[data-toggle="popover"]').popover("hide");

	$.ajax({
		url: '/doacoes/denunciaItemAjax',
		type: 'POST',
		dataType: 'json',
		data: {
			item_vacilao: item_vacilao, 
			usuario_vacilao: usuario_vacilao, 
			usuario_x9: usuario_x9,
			denuncia_text: denuncia_text
		}
	})
	.done(function(data) {
		console.log("success", data);
		if (data['tipo'] == "sucesso")
			$('#modalLabel').html("Denúncia Reportada com sucesso!");
		else
			$('#modalLabel').html("Erro ao reportar sua Denúncia!");
		$('#modalMsg').html(data['msg']);
		$('#mensagem-modal').modal("show");
	})
	.fail(function(data) {
		console.log("error", data);
	});
	
});

function interesse(OBJ, item_id){
	if(OBJ.value=="adicionar"){
		$.ajax({
			url: '/Doacoes/interesse',
			type: 'POST',
			data: { item_id: item_id,
					acao: 	 "adicionar" },
			dataType: "json",
			success: function(data){
				if(data["tipo"] == "erro"){
					mensagem(data["tipo"], data["msg"], "mensagem");
					$("#div_mensagem").show();
				}else{
					// OBJ.className = "btn btn-primary btn-lg";
					OBJ.innerHTML = "<i class='fa fa-minus-circle'></i> Remover interesse";
					OBJ.value 	  = "remover";
					window.location.reload(true);
				}
			},
			error: function(data){
				mensagem("erro", "Ocorreu um problema. Por favor, tente mais tarde ou contate o suporte através do e-mail: <b>suporte@takeit.com.br</b>", "mensagem");
			}
		});
	}else{
		$.ajax({
			url: '/Doacoes/interesse',
			type: 'POST',
			data: { item_id: item_id,
					acao: 	 "remover" },
			dataType: "json",
			success: function(data){
				if(data["tipo"] == "erro"){
					mensagem(data["tipo"], data["msg"], "mensagem");
					$("#div_mensagem").show();
				}else{
					// OBJ.className = "btn btn-primary btn-ls";
					OBJ.innerHTML = "<i class='fa fa-heart'></i> Manifestar interesse";
					OBJ.value 	  = "a";
					window.location.reload(true);
				}
			},
			error: function(data){
				mensagem("erro", "Ocorreu um problema. Por favor, tente mais tarde ou contate o suporte através do e-mail: <b>suporte@takeit.com.br</b>", "mensagem");
			}
		});
	}
}