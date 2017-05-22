/**
 * AINDA NÃO FINALIZADA
 * AINDA NÃO FINALIZADA
 * AINDA NÃO FINALIZADA
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
	$("#" + nome_objeto).html(msg);
}