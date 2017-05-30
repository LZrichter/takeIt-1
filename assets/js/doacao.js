var obrigatorio = 0;

/**
 * Função que carrega uma preview das imagens selecionadsa para o cadastro.
 * @param  {[input type="file"]} input que seleciona a imagem. 
 * @param  {[imgTag]} imgTag, id da tag img onde será carregado a imagem.
 * @return {[void(0)]}
 */
function readURL(input, imgTag){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(imgTag).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function inputIsEmpty(valor, form_group){
	if (!valor.trim() || valor == 'Selecione...'){
		mensagem("erro", "Por favor, preencha os campos obrigatórios.", "mensagem");
        $("#div_mensagem").show();
        form_group.addClass('has-error');
		obrigatorio += 1;
	}
}

$(document).ready(function(){
	
	var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];

	/*Alteração da preview da imagem escolhida*/
	$('#imagem1').on('change', function(event) {
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            mensagem("erro", "Apenas arquivos com extensões <b>.jpg .jpeg .png .gif</b> serão aceitos.   ", "mensagem");
            $("#div_mensagem").show();
            $(this).val("");
        }else{
        	readURL(this, "#img-1");	
        }
	});

	$('#imagem2').on('change', function(event) {
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            mensagem("erro", "Apenas arquivos com extensões <b>.jpg .jpeg .png .gif</b> serão aceitos.   ", "mensagem");
            $("#div_mensagem").show();
            $(this).val("");
        }else{
        	readURL(this, "#img-2");	
        }
	});

	$('#imagem3').on('change', function(event) {
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            mensagem("erro", "Apenas arquivos com extensões <b>.jpg .jpeg .png .gif</b> serão aceitos.   ", "mensagem");
            $("#div_mensagem").show();
            $(this).val("");
        }else{
        	readURL(this, "#img-3");	
        }
	});

	$('#imagem4').on('change', function(event) {
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            mensagem("erro", "Apenas arquivos com extensões <b>.jpg .jpeg .png .gif</b> serão aceitos.   ", "mensagem");
            $("#div_mensagem").show();
            $(this).val("");
        }else{
        	readURL(this, "#img-4");	
        }
	});

	$('#imagem5').on('change', function(event) {
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            mensagem("erro", "Apenas arquivos com extensões <b>.jpg .jpeg .png .gif</b> serão aceitos.   ", "mensagem");
            $("#div_mensagem").show();
            $(this).val();
        }else{
        	readURL(this, "#img-5");	
        }
	});
	
	/**
	 * Função que faz ao submit do form faz um AJAX com as imagens e os campos do form.
	 * @param  {[select]}              categoria:  $("#select_categoria option:selected").text() [valor do select]
	 * @param  {[input type="number"]} quantidade: $("#input_qtde").val() [valor da quantidade]
	 * @param  {[textarea]}            detalhes:   $("#area_detalhes").val() [valor do textarea]
	 * @return {[json]}                [ array de JSON com as validações do formulário]
	 */
	$('#doacaoForm').on('submit', function(event) {
		event.preventDefault();
		$("#div_mensagem").hide();
		$(".fotos-group").removeClass('has-error');

		var filename = $('input[type=file]').val().split('\\').pop();
		if (!filename.trim()) { //se nenhuma imagem for selecionada.
			mensagem("erro", "Você precisa selecionar ao menos <b>uma imagem</b> para a doação!", "mensagem");
			$("#div_mensagem").show();
			$(".fotos-group").addClass('has-error');
			obrigatorio += 1;
		}

		inputIsEmpty($('#input_descricao').val(), $('.descricao-group'));

		inputIsEmpty($('#select_categoria option:selected').text(), $('.categoria-group'));
		
		inputIsEmpty($('#input_qtde').val(), $('.quantidade-group'));

		inputIsEmpty($('#area_detalhes').val(), $('.detalhes-group'));

		if (obrigatorio == 5 ) {
			$('input[type=file]').upload("teste",{
			descricao: $("#input_descricao").val(),
			categoria: $("#select_categoria option:selected").text(),
			idCategoria: $("#select_categoria option:selected").attr("id"),
			quantidade: $("#input_qtde").val(),
			detalhes: $("#area_detalhes").val(),
			idUsuario: 1 //DEVE SER ALTERADO PARA VALOR DA SESSÃO DO USUARIO
			},function(success){	
				console.log("Retorno com sucesso do ajaxUploadFile: ", success);
				var msg = " ";
				var tipo;
				$.each(success, function(index, campo) {
					//if (!jQuery.isEmptyObject(campo["msg"])) //teste se string está vazia
					tipo = campo["tipo"];

					if (tipo === 'erro') {
						msg += "<br>"+campo["msg"];
						$('.'+campo["campo"]+'-group').addClass('has-error');
						mensagem(tipo, msg, "mensagem");
						$("#div_mensagem").show();
					}

					if(tipo === 'sucesso'){
						$('.'+campo["campo"]+'-group').removeClass('has-error');
						$('.'+campo["campo"]+'-group').addClass('has-success');
						$("#div_mensagem").hide();
					}
				});
			});
		}	
	});
});