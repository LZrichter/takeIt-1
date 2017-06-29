var modal = $('#delete-modal');
var mensagemModal = $('#mensagem-modal');
var cancelarDoacao = $('.btn-modal');

$(document).ready(function($) {
	
	var simModal = $('#cancelarDoacao');

	cancelarDoacao.on('click', function(event) {
		event.preventDefault();
		btnModal = jQuery(this).data("id");

		simModal.on('click', function(event) {
			event.preventDefault();
			$.ajax({
				url: '/doacoes/cancelaItemAjax',
				type: 'POST',
				dataType: 'json',
				data: {idItem: btnModal }
			})
			.done(function(data) {
				if(data["tipo"] == "sucesso"){
					modal.modal('hide');
					$('#panel-'+btnModal).css('display', 'none');
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
		
	// 
});