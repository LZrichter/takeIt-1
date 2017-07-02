$('[name="userButton"]').on("click", function(){ atualizaChatCentral($(this)); });

$(document).on("submit", "#formChat", function(e){
    e.preventDefault();

	$.ajax({
		url: 'salvaMensagem',
		type: 'POST',
		data: $("#formChat").serialize(),
		dataType: "json",
		success: function(data){
			console.log(data);
		},
		error: function(data){
			mensagem("erro", "Ocorreu um problema na hora de realizar o cadastro. Por favor, mude os dados inseridos ou tente mais tarde.", "mensagem");
		}
	});

	e.preventDefault();
});

function atualizaChatCentral(obj){
	$.ajax({
		url: "chatInicial",
		data: {
			usuario_id 	 : obj.data("usuarioId"),
			usuario_nome : obj.data("usuarioNome"),
			imagem_link  : obj.data("imagemLink"),
			interesse_id : obj.data("interesseId"),
			item_id 	 : $("#item_id").val(),
			tipo_pessoa  : $("#tipo_pessoa_chat").val()
		},
		type: "POST",
		success: function(data){
			$("#painelMsgs").html(data);
		}
	});
}