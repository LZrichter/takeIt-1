var id_interesse;

$(document).on("click" , "#agradecer", function(e){
	e.preventDefault();

	id_interesse = $(this).data("interesse");
	
});

$('#enviarAgradecimento').on("click", function(e){
		e.preventDefault();

		var agradecimento = $("#agradecimento").val();

		$.ajax({
			url: '/doacoes/agradecimentoAjax/',
			type: 'POST',
			dataType: 'json',
			data: {id_interesse: id_interesse, agradecimento : agradecimento}
		})
		.done(function(data) {
			if( data["tipo"] == "sucesso" ){
				$('#labelRetorno').html("Agradecimento registrado!");
				$('#bodyRetorno').html(data["msg"]+" Seu feedback é muito importante para nós <i class='fa fa-heart'></i>");
				$('#modalRetorno').modal('show');
				$("#agradecer").prop("disabled", true);
			}else{
				$('#labelRetorno').html("Erro ao registrar agradecimento!");
				$('#bodyRetorno').html(data["msg"]);
				$('#modalRetorno').modal('show');
			}
		})
		.fail(function(data) {
			if( data["tipo"] == "erro" ){
				$('#labelRetorno').html("Erro ao registrar agradecimento!");
				$('#bodyRetorno').html(data["msg"]);
				$('#modalRetorno').modal('show');
			}
		});
});