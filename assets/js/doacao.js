var obrigatorio      = 0;
var input_descricao  = $('#input_descricao');
var select_categoria = $('#select_categoria');
var input_qtde       = $('#input_qtde');
var area_detalhes    = $('#area_detalhes');
var div_mensagem     = $('#div_mensagem');
var user_id          = $('#user_id');
var input_img_1      = $('#imagem1');
var input_img_2      = $('#imagem2');
var input_img_3      = $('#imagem3');
var input_img_4      = $('#imagem4');
var input_img_5      = $('#imagem5');
var thumb_img_1      = $('#img-1');
var thumb_img_2      = $('#img-2');
var thumb_img_3      = $('#img-3');
var thumb_img_4      = $('#img-4');
var thumb_img_5      = $('#img-5');
var group_descricao  = $('.descricao-group');
var group_categoria  = $('.categoria-group');
var group_qtde       = $('.quantidade-group');
var group_detalhes   = $('.detalhes-group');
var group_fotos      = $('.fotos-group');

/**
 * Função que carrega uma preview das imagens selecionadsa para o cadastro.
 * @param  {[input type="file"]} input que seleciona a imagem. 
 * @param  {[imgTag]} imgTag, id da tag img onde será carregado a imagem.
 * @return {[void(0)]}
 */
function readURL(input, imgTag){
	
    if (input.files && input.files[0]) {
    	if((input.files[0].size/1000) > 2048){
    		return false;
    	}
        var reader = new FileReader();
        reader.onload = function (e) {
            imgTag.attr('src', e.target.result);

        }
        reader.readAsDataURL(input.files[0]);
        return true;
    }
}

function inputIsEmpty(valor, form_group){
	if (!valor.trim() || valor == 'Selecione...'){
		mensagem("erro", "Por favor, preencha os campos obrigatórios.", "mensagem");
        div_mensagem.show();
        form_group.addClass('has-error');
		obrigatorio += 1;
	}else{
		form_group.removeClass('has-error');
		form_group.addClass('has-success');
	}
}

function loadImagem(input, loadImg, img){
	var old_img_src = img.attr("src"); 
	var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
	if ($.inArray(input.val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        mensagem("erro", "Apenas arquivos com extensões <b>.jpg .jpeg .png .gif</b> serão aceitos.   ", "mensagem");
        div_mensagem.show();
        input.val("");
        img.attr("src", old_img_src);
    }else{
    	if(!readURL(loadImg, img)){
    		mensagem("erro", "Apenas arquivos <b>menores de 2MB</b> serão aceitos.", "mensagem");
        	div_mensagem.show();
        	input.val("");
        	img.attr("src",old_img_src);
    	}
    }
}

function limpaCampos(){
	input_descricao.val("");
	$('select#select_categoria').val("Selecione...");
	input_qtde.val("1");
	area_detalhes.val("");
	$('.add-img').attr("src", "http://takeit/assets/img/add-img.png");
	$('input[type=file]').val("");
	group_descricao.removeClass('has-error');
	group_descricao.removeClass('has-success');
	group_categoria.removeClass('has-error');
	group_categoria.removeClass('has-success');
	group_qtde.removeClass('has-error');
	group_qtde.removeClass('has-success');
	group_detalhes.removeClass('has-error');
	group_detalhes.removeClass('has-success');
	group_fotos.removeClass('has-error');
	group_fotos.removeClass('has-success');
}

$(document).ready(function(){
	/*Alteração da preview da imagem escolhida*/
	input_img_1.on('change', function(event) { loadImagem(input_img_1, this, thumb_img_1) });
	input_img_2.on('change', function(event) { loadImagem(input_img_2, this, thumb_img_2) });
	input_img_3.on('change', function(event) { loadImagem(input_img_3, this, thumb_img_3) });
	input_img_4.on('change', function(event) { loadImagem(input_img_4, this, thumb_img_4) });
	input_img_5.on('change', function(event) { loadImagem(input_img_5, this, thumb_img_5) });
	
	/* Função que faz ao submit do form faz um AJAX com as imagens e os campos do form.
	 * @param  {[select]}              categoria:  $("#select_categoria option:selected").text() [valor do select]
	 * @param  {[input type="number"]} quantidade: $("#input_qtde").val() [valor da quantidade]
	 * @param  {[textarea]}            detalhes:   $("#area_detalhes").val() [valor do textarea]
	 * @return {[json]}                [ array de JSON com as validações do formulário]
	 */
	$('#doacaoForm').on('submit', function(event) {
		event.preventDefault();
		div_mensagem.hide();
		group_fotos.removeClass('has-error');
		obrigatorio = 0;
		var option_categoria = $('#select_categoria option:selected');

		var count = 0; 
		for (var i = 1; i <= 5; i++) {
			if (!$("#imagem"+i).val().split('\\').pop().trim()) //se nenhuma imagem for selecionada.
				count += 1;	
		}

		group_descricao.removeClass('has-error');
		group_categoria.removeClass('has-error');
		group_qtde.removeClass('has-error');
		group_detalhes.removeClass('has-error');
		group_fotos.removeClass('has-error');

		inputIsEmpty(input_descricao.val(), group_descricao);
		inputIsEmpty(option_categoria.text(), group_categoria);
		inputIsEmpty(input_qtde.val(), group_qtde);
		inputIsEmpty(area_detalhes.val(), group_detalhes);

		// Alterar o item
		if ($('input[name=alterar]').val() == 1 && $('input[name=alterar]') != undefined) { 
			
			var old_path = $('input[name=old_path]');
			var item_id = $('input[name=item_id]');

			// Ao menos uma imagem foi alterada
			if (obrigatorio == 0 && count != 5 ){
				$('input[type=file]').upload("/doacoes/alteraItemAjax",{
					alterouImagem: 1,
					descricao: input_descricao.val(),
					categoria: option_categoria.text(),
					idCategoria: option_categoria.attr("id"),
					quantidade: input_qtde.val(),
					detalhes: area_detalhes.val(),
					idUsuario: user_id.val(),
					idItem: item_id.val(),
					oldPath: old_path.val(),
					oldFotos: $("input[name='imgOld\\[\\]']").map(function(){return $(this).val();}).get()
				},function(success){
					var msg = " ";
					var tipo;
					$.each(success, function(index, campo) {
						//if (!jQuery.isEmptyObject(campo["msg"])) //teste se string está vazia
						tipo = campo["tipo"];
						if (tipo == 'erro') {
							msg += "<br>"+campo["msg"];
							$('.'+campo["campo"]+'-group').addClass('has-error');
							mensagem(tipo, msg, "mensagem");
							div_mensagem.show();
						}
						if(tipo == 'sucesso'){
							$('.'+campo["campo"]+'-group').removeClass('has-error');
							$('.'+campo["campo"]+'-group').addClass('has-success');
							if (campo["msg"] != undefined){
								mensagem("sucesso", campo["msg"], "mensagem");
								div_mensagem.show();
							}
						}
					});
				});
			}

			// Nenhuma imagem slecionada não precisa alterar as imagens do banco
			if(obrigatorio == 0 && count == 5){
				var alterouImagem = 0;
				var descricao = input_descricao.val();
				var categoria = option_categoria.text();
				var idCategoria = option_categoria.attr("id");
				var quantidade = input_qtde.val();
				var detalhes = area_detalhes.val();
				var idUsuario = user_id.val();
				var idItem = item_id.val();
				var oldPath = old_path.val();
				var oldFotos = $("input[name='imgOld\\[\\]']").map(function(){return $(this).val();}).get();

				$.ajax({
					url: '/doacoes/alteraItemAjax',
					type: 'POST', 
					dataType: 'json',
					data: {
						alterouImagem: alterouImagem, 
						descricao: descricao, 
						categoria: categoria,
						idCategoria: idCategoria, 
						quantidade: quantidade, 
						detalhes: detalhes, 
						idUsuario: idUsuario, 
						idItem : idItem,
						oldPath:  oldPath,
						oldFotos: oldFotos
					},
				})
				.done(function(retorno) {
					console.log("success", retorno);
					var msg = " ";
					var tipo;
					$.each(retorno, function(index, campo) {
						//if (!jQuery.isEmptyObject(campo["msg"])) //teste se string está vazia
						tipo = campo["tipo"];

						if (tipo == 'erro') {
							msg += "<br>"+campo["msg"];
							$('.'+campo["campo"]+'-group').addClass('has-error');
							mensagem(tipo, msg, "mensagem");
							div_mensagem.show();
						}

						if(tipo == 'sucesso'){
							$('.'+campo["campo"]+'-group').removeClass('has-error');
							$('.'+campo["campo"]+'-group').addClass('has-success');
							if (campo["msg"] != undefined){
								mensagem("sucesso", campo["msg"], "mensagem");
								div_mensagem.show();
							}
						}
					});
					
				})
				.fail(function(retorno) {
					console.log("error", retorno);
					var msg = " ";
					var tipo;
					$.each(retorno, function(index, campo) {
						//if (!jQuery.isEmptyObject(campo["msg"])) //teste se string está vazia
						tipo = campo["tipo"];

						if (tipo == 'erro') {
							msg += "<br>"+campo["msg"];
							$('.'+campo["campo"]+'-group').addClass('has-error');
							mensagem(tipo, msg, "mensagem");
							div_mensagem.show();
						}
					});
				});
			}
		// Cadastrar
		} else {
			if (count == 5) {
				mensagem("erro", "Você precisa selecionar ao menos <b>uma imagem</b> para a doação!", "mensagem");
				div_mensagem.show();
				group_fotos.addClass('has-error');	
				obrigatorio += 1;	
			}

			if (obrigatorio == 0 ){
				$('input[type=file]').upload("cadastraItemAjax",{
					descricao: input_descricao.val(),
					categoria: option_categoria.text(),
					idCategoria: option_categoria.attr("id"),
					quantidade: input_qtde.val(),
					detalhes: area_detalhes.val(),
					idUsuario:  user_id.val()
				},function(success){	
					var msg = " ";
					var tipo;
					$.each(success, function(index, campo) {
						tipo = campo['tipo'];
						if (tipo == 'erro') {
							msg += "<br>"+campo["msg"];
							$('.'+campo["campo"]+'-group').addClass('has-error');
							mensagem(tipo, msg, "mensagem");
							div_mensagem.show();
						}

						if(tipo == 'sucesso'){
							$('.'+campo["campo"]+'-group').removeClass('has-error');
							$('.'+campo["campo"]+'-group').addClass('has-success');
							if (campo["msg"] != undefined){
								mensagem("sucesso", campo["msg"], "mensagem");
								div_mensagem.show();
								limpaCampos();
							}
						}
					});
				});
			}
		}		
	});

	$('#doacaoForm').on('reset', function(event) {
		limpaCampos();
	});
});
