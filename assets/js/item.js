
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