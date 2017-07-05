/**
 * Função de mensagens padrão para o sistema, criando uma div com a mensagem passada
 * @param  {string} tipo        Tipo da mensagem, podendo ser:
 *     'normal' 	como branco 		(default)
 *     'info'		como azul claro 	(info)
 *     'ok' 		como azul escuro 	(primary)
 *     'sucesso' 	como verde 			(success)
 *     'atencao' 	como amarelo 		(warning)
 *     'erro' 		como vermelho 		(danger)
 * @param  {string} msg         A mensagem a ser inserida dentro da div da mensagem
 * @param  {string} nome_objeto Nome do objeto HTML que a div será inserida
 * @return {void}
 */	
function mensagem(tipo, msg, nome_objeto){
	$("#" + nome_objeto).html("");
	if(tipo == "erro"){
		$("#" + nome_objeto).append('<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erro!</strong> ' + msg + '</div>');
	}else if(tipo == "sucesso"){
		$("#" + nome_objeto).append('<div class="alert alert-success alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + msg + '</div>');
	}else $("#" + nome_objeto).html(msg);
}

$(document).ready(function() {
    $.ajax({
		url: '/Painel/getQuantidade',
		type: 'POST',
		dataType: "json"
	}).done(function(data) {
			$('#badge').text(data['paginas_qtde']);
			console.log(data['paginas_qtde']);
	}).fail(function() {
			console.log("error");
	});
});