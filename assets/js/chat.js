// Vai ficar buscando sempre por uma mensagem nova que pode ter sido mandada
var carregandoChat = setInterval(function(){ carregaMsgsChat(); }, 1000);
var carregandocountNaoLidas = setInterval(function(){ carregacountNaoLidas(); }, 1000);

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
			}, error: function(data){
			    $("#modal_msg").html("Ocorreu um problema na hora de realizar o cadastro. Por favor, mude os dados inseridos ou tente mais tarde.");			   
			    $("#modal_aviso").css("overflow", "hidden");
			    $('#modal_aviso').modal('show');
			}
		});
    }

	e.preventDefault();
});

$(document).on("click", "#botao_cancelar_sim", function(){
	$.ajax({
		url: 'cancelarBatePapo',
		type: 'POST',
		data:{
			interesse_id: $('[name="interesse_id"]').val()
		},
		dataType: "json",
		success: function(data){
			if(data["tipo"] == "sucesso"){
				atualiza_meio();
			}else{
			    $("#modal_msg").html(data["msg"]);
			    $("#modal_aviso").css("overflow", "hidden");
			    $('#modal_aviso').modal('show');
			}
		}, error: function(data){
		    $("#modal_msg").html("Ocorreu um problema na hora de cancelar. Por favor, tente mais tarde.");
		    $("#modal_aviso").css("overflow", "hidden");
		    $('#modal_aviso').modal('show');
		}
	});
});

// Responsavel pelo botão de doar item
$(document).on("click", "#botao_doar_sim", function(){
	if(!eval($('#qtde_itens').val() <= $("#qtdeRestante").html())){
		$('[name="qtd-itens"]').addClass("alert alert-danger mudanca-button-doacao");
		$('[name="qtd-itens"]').focus();
	}else{
		$.ajax({
			url: 'doarItem',
			type: 'POST',
			data: {
				item_id: $('#item_id').val(),
				interesse_id: $('[name="interesse_id"]').val(),
				qtde_itens: $('[name="qtd-itens"]').val()
			},
			dataType: "json",
			success: function(data){
				if(data["tipo"] == "sucesso"){
					atualiza_meio();
				}else{
				    $("#modal_msg").html(data["msg"]);
				    $("#modal_aviso").css("overflow", "hidden");
				    $('#modal_aviso').modal('show');
				}
			}, error: function(data){
			    $("#modal_msg").html("Ocorreu um problema na hora de doar. Por favor, tente mais tarde.");			   
			    $("#modal_aviso").css("overflow", "hidden");
			    $('#modal_aviso').modal('show');
			}
		});
	}
});

// Teste para verificar se a quantidade correta com o limite
$(document).on("change", "#qtde_itens", function(){
	if(eval($(obj).val() <= $("#qtdeRestante").html())){
		$(obj).removeClass("alert alert-danger mudanca-button-doacao");
	}else{
		$(obj).addClass("alert alert-danger mudanca-button-doacao");
	}
});

// É chamada constântemente e é responsavel por colocar novas mensagens no chat
function carregaMsgsChat(){
	if((typeof $("[name='interesse_id']").val() != "undefined") && (typeof $("#id_ultima_msg").val() != "undefined")){
		$.ajax({
			url: 'buscarMensagensNovas',
			type: 'POST',
			data: {
				idInteresse: $("[name='interesse_id']").val(),
				IDUltimaMsg: $("#id_ultima_msg").val(),
				tipo_pessoa: $("#tipo_pessoa_chat").val()
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
							$("#inputMsg").focus();
							$("#id_ultima_msg").val(msg.chat_id);
						}
					});
				}
			}, error: function(data){
				mensagem("erro", "Ocorreu um problema na hora de realizar o cadastro. Por favor, mude os dados inseridos ou tente mais tarde.", "mensagem");
			}
		});
	}
}

// É chamada constântemente e é responsavel por contar o numero de mensgens não lidas
function carregacountNaoLidas(){
	$.ajax({
		url: 'buscaCountNaoLidas',
		type: 'POST',
		data: {
			item_id: $("#item_id").val()
		},
		dataType: "json",
		success: function(data){
			var divs = $('[class="col-xs-1 col-md-1 user-count"]');

			for (var i = 0; i < divs.length; i++){
				if(data != null && typeof data[$(divs[i]).data("interesseId")] !== "undefined")
					$(divs[i]).html("<p>" + data[$(divs[i]).data("interesseId")].num + "</p>");
				else
					$(divs[i]).html("<p>0</p>");
			}
		}, error: function(data){
		    console.log("----- Erro no count! -----");
		    console.log(data);
		    console.log("--------------------------");
		}
	});
}

function atualiza_meio(){
	$.ajax({
		url: "chatInicial",
		data: {
			usuario_id 	 : $("#selecionado_usuario_id").val(),
			usuario_nome : $("#nomePessoa").html(),
			imagem_link  : $("#selecionado_img_pessoa").val(),
			interesse_id : $('[name="interesse_id"]').val(),
			item_id 	 : $("#item_id").val(),
			tipo_pessoa  : $("#tipo_pessoa_chat").val()
		},
		type: "POST",
		success: function(data){
			$("#painelMsgs").html(data);
		}
	});
}