
$(document).on('click', '.btn-ignorar', function(event) {
	event.preventDefault();
	var id = $(this).data("id");
	var title = $(this).data("title");
	var painel = $(this).data("panel");

	$('#action-modal-title').html(title);

	$('#modal-sim-btn').on('click', function(event) {
		event.preventDefault();
		$.ajax({
			url: '/painel/ignorarDenuncia/'+id,
			type: 'POST',
			dataType: 'json',
		})
		.done(function(data) {
			if (data['tipo'] == 'sucesso') {
				$('#action-modal').modal("hide");
				$('#modalLabel').html(data['msg']);
				$('#modalMsg').html("Essa denúncia ficara visível na aba de denuncias resolvidas.");
				$('#mensagem-modal').modal("show");
				$('#'+painel).css('display', 'none');	
			}else{
				$('#action-modal').modal("hide");
				$('#modalLabel').html("Erro ao ignorar a denúncia!!");
				$('#modalMsg').html(data['msg']);
				$('#mensagem-modal').modal("show");
			}
			

		})
		.fail(function(data) {
			$('#action-modal').modal("hide");
			$('#modalLabel').html("Erro ao ignorar a denúncia!!");
			$('#modalMsg').html("Por favor tente novamente mais tarde.");
			$('#mensagem-modal').modal("show");
		});
	});
});


$(document).on('click', '.btn-usuario', function(event) {
	event.preventDefault();
	var idUser = $(this).data("id");
	var idDenuncia = $(this).data("denuncia");
	var title = $(this).data("title");
	var painel = $(this).data("panel");

	$('#action-modal-title').html(title);

	$('#modal-sim-btn').on('click', function(event) {
		event.preventDefault();
		$.ajax({
			url: '/painel/cancelarUsuario/',
			type: 'POST',
			dataType: 'json',
			data: { idDenuncia : idDenuncia, idUser : idUser}
		})
		.done(function(data) {
			console.log('done', data);
			if (data['tipo'] == 'sucesso') {
				$('#action-modal').modal("hide");
				$('#modalLabel').html(data['msg']);
				$('#modalMsg').html("Todos os itens referentes a este usuario foram excluidos");
				$('#mensagem-modal').modal("show");
				$('#'+painel).css('display', 'none');
				window.location.reload(true);
			}else{
				$('#action-modal').modal("hide");
				$('#modalLabel').html("Erro ao bloaquear este usuário!!");
				$('#modalMsg').html(data['msg']);
				$('#mensagem-modal').modal("show");
			}
		})
		.fail(function(data) {
			console.log('fail', data);
			$('#action-modal').modal("hide");
			$('#modalLabel').html("Erro ao bloaquear este usuário!!");
			$('#modalMsg').html(data["msg"]);
			$('#mensagem-modal').modal("show");
		});
	});
});

$(document).on('click', '.btn-item', function(event) {
	event.preventDefault();
	var id = $(this).data("id");
	var title = $(this).data("title");
	var painel = $(this).data("panel");
	var idDenuncia = $(this).data("denuncia");

	$('#action-modal-title').html(title);

	$('#modal-sim-btn').on('click', function(event) {
		event.preventDefault();
		$.ajax({
			url: '/doacoes/cancelaItemAjax',
			type: 'POST',
			data: {idItem : id },
			dataType: 'json'
		})
		.done(function(data) {

			var msg = data['msg'];

			if (data['tipo'] == 'sucesso'){
				$.ajax({
					url: '/painel/resolverDenuncia/'+idDenuncia,
					type: 'POST',
					dataType: 'json'
				})
				.done(function(data) {
					if (data['tipo'] == 'sucesso') {
						$('#action-modal').modal("hide");
						$('#modalMsg').html(msg+data['msg']);
						$('#mensagem-modal').modal("show");
						$('#'+painel).css('display', 'none');
					}
				});		
			}else{
				$('#action-modal').modal("hide");
				$('#modalLabel').html("Erro ao cancelar o item!!");
				$('#modalMsg').html(data['msg']);
				$('#mensagem-modal').modal("show");
			}
		})
		.fail(function(data) {
			$('#action-modal').modal("hide");
			$('#modalLabel').html("Erro ao cancelar o item!!");
			$('#modalMsg').html("Por favor tente novamente mais tarde.");
			$('#mensagem-modal').modal("show");
		});
	});
});