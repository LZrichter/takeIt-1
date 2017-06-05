var cancelarDoacao = $('.btn-modal').attr('id');
var modal = $('#delete-modal');
var mensagemModal = $('#mensagem-modal');

$(document).ready(function($) {
	
	var simModal = $('#cancelarDoacao');

	simModal.on('click', function(event) {
		event.preventDefault();
		$.ajax({
			url: '/doacoes/cancelaItemAjax',
			type: 'POST',
			dataType: 'json',
			data: {idItem: cancelarDoacao }
		})
		.done(function(data) {
			if(data["tipo"] == "sucesso"){
				modal.modal('hide');
				$('#panel-'+cancelarDoacao).css('display', 'none');
				$('#modalLabel').text(data["tipo"]+" ao cancelar esta doação!");
				$('#modalMsg').text(data["msg"]);
				mensagemModal.modal('show');
			}else{
				modal.modal('hide');
				$('#modalLabel').text(data["tipo"]+" ao cancelar esta doação!");
				$('#modalMsg').text(data["msg"]);
				mensagemModal.modal('show');
			}
		})
		.fail(function(data) {
			console.log("Erro: ",data);
		});
		
	});
});