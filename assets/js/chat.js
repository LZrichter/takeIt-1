// Vai ficar buscando sempre por uma mensagem nova que pode ter sido mandada
var carregandoChat = setInterval(function(){ carregaMsgsChat(); }, 1000);

// Carrega o chat de um usuário
$('[name="userButton"]').on("click", function(){ 
	$.ajax({
		url: "chatInicial",
		data: {
			usuario_id 	 : $(this).data("usuarioId"),
			usuario_nome : $(this).data("usuarioNome"),
			imagem_link  : $(this).data("imagemLink"),
			interesse_id : $(this).data("interesseId"),
			item_id 	 : $("#item_id").val(),
			tipo_pessoa  : $("#tipo_pessoa_chat").val()
		},
		type: "POST",
		success: function(data){
			$("#painelMsgs").html(data);
		}
	});
});

// Salva uma nova mensagem mandada no chat e mostra ela
$(document).on("submit", "#formChat", function(e){
    e.preventDefault();

    if($("#inputMsg").val().trim().length > 0){
    	$.ajax({
			url: 'salvaMensagem',
			type: 'POST',
			data: $("#formChat").serialize(),
			dataType: "json",
			success: function(data){
				var id_box = "chat_mensagem_"+data.msg["id"];

				$("#centro_mensagens").append('<div class="alert alert-info col-sm-8 col-sm-offset-4 text-right" id="' + id_box + '" tabindex="1"><p>' + data.msg["msg"] + '</p><div class="data-enviado-direita pull-left">Enviado: ' + data.msg["data"] + '</div></div>');

				$('#' + id_box).focus();
				
				$("#inputMsg").val("").focus();
				$("#id_ultima_msg").val(data.msg["id"]);
			},
			error: function(data){
				mensagem("erro", "Ocorreu um problema na hora de realizar o cadastro. Por favor, mude os dados inseridos ou tente mais tarde.", "mensagem");
			}
		});
    }

	e.preventDefault();
});

function carregaMsgsChat(){
	if((typeof $("[name='interesse_id']").val() != "undefined") && (typeof $("#id_ultima_msg").val() != "undefined")){
		$.ajax({
			url: 'buscarMensagensNovas',
			type: 'POST',
			data: {
				idInteresse: $("[name='interesse_id']").val(),
				IDUltimaMsg: $("#id_ultima_msg").val()
			},
			dataType: "json",
			success: function(data){
				if(data != null){
					$.each(data, function(i, msg){
						var id_box = "chat_mensagem_"+msg.chat_id;

						if($("[name='tipo_pessoa']").val() == msg.chat_quem) 
							var classe = ["alert alert-info col-sm-8 col-sm-offset-4 text-right", "data-enviado-direita pull-left"];
						else 
							var classe = ["alert alert-success col-sm-8", "data-enviado-esquerda pull-right"];

						if($.type($("#" + id_box).html()) == "undefined"){
							$("#centro_mensagens").append('<div class="' + classe[0] + '" id="' + id_box + '" tabindex="1"><p>' + msg.chat_text + '</p><div class="' + classe[1] + '">Enviado: ' + msg.chat_data_formatada + '</div></div>');

							$('#' + id_box).focus();
							$("#inputMsg").val("").focus();
							$("#id_ultima_msg").val(msg.chat_id);
						}
					});
				}
			},
			error: function(data){
				mensagem("erro", "Ocorreu um problema na hora de realizar o cadastro. Por favor, mude os dados inseridos ou tente mais tarde.", "mensagem");
			}
		});
	}
}