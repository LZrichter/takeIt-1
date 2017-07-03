/**
 * Adiciona uma nova linha de categoria
 * @param  {objeto} OBJ Botão que foi clicado
 * @return {void}       Mostra nova linha
 */
function adicionaCategoria(OBJ){
	var nodulo = OBJ.parentNode.parentNode;
	var novo = nodulo.cloneNode(true);

	for(i=0; i<novo.childNodes.length; i++)
		if(novo.childNodes[i].id == "div_select"){
			novo.childNodes[i].childNodes[1].selectedIndex = 0;
			break;
		}

	nodulo.parentNode.append(novo);
}

/**
 * Remove a linha da categoria
 * @param  {objeto} OBJ Botão que foi clicado
 * @return {void}       Exclui a linha
 */
function removerCategoria(OBJ){
	var nodulo = OBJ.parentNode.parentNode;
	nodulo.remove();
}

/**
 * Quando é dado submit no formulário, aqui ele é enviado por ajax
 */
$("#form_categorias").on("submit", function(event){
	event.preventDefault();

	$("#btnSend").button('loading');
	$.ajax({
		url: 'atualiza_categorias',
		type: 'POST',
		data: $("#form_categorias").serialize(),
		dataType: "json",
		success: function(data){
			$("#btnSend").button('reset');
			mensagem(data["tipo"], data["msg"], "mensagem");
			$("#div_mensagem").show();
		},
		error: function(data){
			$("#btnSend").button('reset');
			mensagem("erro", "Ocorreu um problema. Por favor, tente mais tarde ou contate o suporte através do e-mail: <b>suporte@takeit.com.br</b>", "mensagem");
		}
	});
	event.preventDefault();
});