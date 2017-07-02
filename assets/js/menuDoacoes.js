var sel_estado 		= $('.estados');
var sel_municipios 	= $('.municipios');
var sel_categorias 	= $('.categorias');
var btn_menu		= $('#filtro-pesquisa');
var btn_close		= $('.closebtn');
var itens			= $('.bloco-doacoes');


/**
 * Função que retorna todos os estados e os coloca dentro do select de estados 
 * @return {vetor[posicao][dado]} [vetor retornado por AJAX]
 */
function todosEstados(idEstado, idCidade){
	var idE = idEstado;
	var idC = idCidade;
	$.ajax({
		url: '/doacoes/carregaEstadosMenu',
		type: 'POST',
		dataType: 'json',
	})
	.done(function(msg) {
		for (var i = 0; i <= msg.length-1; i++) {
			if (msg[i]['id'] == idE) {
				sel_estado.append("<option id='"+msg[i]['id']+"' selected >"+msg[i]['uf']+"</option>");
			} else {
				sel_estado.append("<option id='"+msg[i]['id']+"' >"+msg[i]['uf']+"</option>");
			}
			
		}
		var estado = $(".estados option:selected").attr("id");
        municipiosPorEstado(estado, idC);
	})
	.fail(function() {
		console.log("error ao preencher o menu de estados");
	});
		
}

/**
 * Função que retorna todos os municipios e os coloca dentro do select de municipios
 * com base no id do estado passado como parametro
 * @param {[int]} [estado]
 * @return {vetor[posicao][dado]} [vetor retornado por AJAX]
 */
function municipiosPorEstado(estado, cidade=0){
	var idE = estado;
	var idC = cidade;
	var flag = 0;
	$.ajax({
		url: '/doacoes/carregaMunicipiosMenu/'+idE,
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data) {
		sel_municipios.empty();
		for (var i = 0; i <= data.length-1; i++) {
			if (data[i]['id'] == idC) {
				sel_municipios.append("<option id='"+data[i]['id']+"' selected >"+data[i]['nome']+"</option>");
				flag = 1;
			} else {
				if (i == data.length-1 && flag == 0) {
					sel_municipios.append("<option id='"+data[i]['id']+"' selected >"+data[i]['nome']+"	</option>");
					mudaCidade($(".municipios option:selected").attr("id"));
				} else {
					sel_municipios.append("<option id='"+data[i]['id']+"' >"+data[i]['nome']+"</option>");
				}
				
			}
		}
	})
	.fail(function() {
		console.log("error");
	});
	
}

/**
 * Função que retorna todas categorias do banco de dados e as insere no select de categorias
 * @return {vetor[posicao][dado]} [vetor de categorias]
 */
function todasCategorias(categoria){
	idC = categoria;
	$.ajax({
		url: '/doacoes/carregaCategoriasMenu',
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data){
		for (var i = 0; i <= data.length-1; i++) {
			if (data[i]['categoria_id'] == idC) {
				sel_categorias.append("<li id='"+data[i]['categoria_id']+"' class='list-group-item categ' style='background-color: #31b0d5' >"+data[i]['categoria_nome']+"</li>");
			} else {
				sel_categorias.append("<li id='"+data[i]['categoria_id']+"' class='list-group-item categ' >"+data[i]['categoria_nome']+"</li>");
			}
		}
	})
	.fail(function(){
		console.log("error");
	});
}

function openMenuFilter() {
    $("#mySidenav").css("width","250px");
}

function closeMenuFilter() {
    $("#mySidenav").css("width","0px");
}

function mudaEstado(estado) {
	$.ajax({
		url: '/doacoes/setEstado/'+estado,
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data) {
		
	})
	.fail(function() {
		console.log("error");
	});
}

function mudaIndice(indice) {
	$.ajax({
		url: '/doacoes/setIndice/'+indice,
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data) {
		
	})
	.fail(function() {
		console.log("error");
	});
}

function mudaCidade(cidade){
	$.ajax({
		url: '/doacoes/setSessaoCidade/'+cidade,
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data) {
		window.location.reload();
	})
	.fail(function() {
		console.log("error");
	});
}

function mudaCategoria(categoria){
	$.ajax({
		url: '/doacoes/setSessaoCategoria/'+categoria,
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data) {
		location.reload();
	})
	.fail(function() {
		console.log("error");
	});
}

$(document).ready(function(){

	var estado_filtro = $('#idEstado').attr("value");
	var cidade_filtro = $('#idCidade').attr("value");
	todosEstados(estado_filtro, cidade_filtro);

	var categoria_filtro = $('#idCategoria').attr("value");
	todasCategorias(categoria_filtro);


	/* TODO	
	 *
	 * - Pegar o estado do usuário logado em um input hidden
	 * - e selecionar as cidades no select
	 * 
	 */


	/**
	 * Verifica alteracoes no select de estados
	 * @param {[int]} [idEstado] [id da tag option de cada Estado]
	 * Preenche o select de municipios com base no id do estado
	 */
	$( ".estados" ).on("change", function() {
        	var idEstado = $(".estados option:selected").attr("id");
        	municipiosPorEstado(idEstado);
        	mudaIndice(1);
        	mudaEstado(idEstado);
    	}
	);

	/**
	 * Verifica alteracoes no select de cidades
	 * @param {[int]} [idCidade] [id da tag option de cada Cidade]
	 */
	$( ".municipios" ).on("change", function() {
        	var idCidade = $(".municipios option:selected").attr("id");
        	mudaIndice(1);
        	mudaCidade(idCidade);console.log(idCidade);
    	}
	);

	/**
	 * Função para ao selecionar uma categoria retornar os itens 
	 * da categoria com base no id da cidade.
	 * 
	 */
	$(".categorias").on("click", ".categ", function(event) {
			/* chamar controle que carrega as doacoes filtradas */
			$( this ).css("background-color: #31b0d5");
			mudaIndice(1);
			mudaCategoria($( this ).attr("id"));
		}
	);

	/**
	 * Abre o menu lateral com os filtros ao clicar no botão ou no hover
	 * 
	 */
	btn_menu.on('click',
	 	function(event) {
			event.preventDefault();
			openMenuFilter();
	});


	/**
	 * Fecha o menu lateral com os filtros ao clicar no botão X
	 * 
	 */
	btn_close.on('click',
	 	function(event) {
			event.preventDefault();
			closeMenuFilter();
	});

});