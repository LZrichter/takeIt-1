$(document).on("click" , "#agradecer", function(e){
	e.preventDefault();

	var id_interesse = $(this).data("interesse");

	$(document).on("submit", "formAgradecimento", function(e){
		e.preventDefault();

		var agradecimento = $('#agradecimento').val();

		$.ajax({
			url: '/doacoes/agradecimentoAjax/',
			type: 'POST',
			dataType: 'json',
			data: {id_interesse: id_interesse}
		})
		.done(function(data) {
			console.log("success", data);
		})
		.fail(function(data) {
			console.log("error", data);
		});
	});
});