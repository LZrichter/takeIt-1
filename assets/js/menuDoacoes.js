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
function todosEstados(){
	$.ajax({
		url: '/doacoes/carregaEstadosMenu',
		type: 'POST',
		dataType: 'json',
	})
	.done(function(msg) {
		for (var i = 0; i <= msg.length-1; i++) {
			sel_estado.append("<option id='"+msg[i]['id']+"' >"+msg[i]['uf']+"</option>");
		}
		var idEstado = $(".estados option:selected").attr("id");
        municipiosPorEstado(idEstado);
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
function municipiosPorEstado(estado){
	$.ajax({
		url: '/doacoes/carregaMunicipiosMenu/'+estado,
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data) {
		sel_municipios.empty();
		for (var i = 0; i <= data.length-1; i++) {
			sel_municipios.append("<option id='"+data[i]['id']+"' >"+data[i]['nome']+"</option>");
		}
	})
	.fail(function() {
		console.log("error");
	});
	
}

function filtraDoacoes(){
	$.ajax({
		url: '/doacoes/filtraDoacoes/1/4214/3/""',
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data) {console.log(teste);
		itens.empty();
		var str = "";
		for (var i = 0; i < Object.keys(data).length-1; i++) {
			str += "<div class='col-item'>\
		   	    <div class='photo'>\
		   	        <a href='doacoes/item/"+data[i]['item_id']+"' alt='Veja todas as fotos da doação.'>\
	   		            <img src='http://takeit/"+data[i]['imagem_caminho'].substring(2)+"/"+data[i]['imagem_nome']+
						"' class='img-thumbnail img-responsive' alt='Foto do produto'  />\
	   		            <div class='overlay'>\
	   						<div class='text'><span class='fa fa-plus'></span> Ver Produto</div>\
	   		  			</div>\
	   		  		</a>\
		   	    </div>\
		   	    <div class='info'>\
		            <div class='titulo text-center'>\
		                <h5>"+data[i]['item_descricao'] +"</h5>\
		            </div>\
					<div class='button text-center'>\
						<a href='#'>\
							<button type='button' class='btn btn-danger btn-sm'>\
						    	<i class='fa fa-heart'></i> Manifestar interesse\
							</button>\
						</a>\
					</div>\
		   	        <div class='clearfix'>\
		   	        </div>\
		   	    </div>\
			</div>";
		}
		itens.append(str);
	})
	.fail(function() {
		console.log("error");
	});
	
}

/**
 * Função que retorna todas categorias do banco de dados e as insere no select de categorias
 * @return {vetor[posicao][dado]} [vetor de categorias]
 */
function todasCategorias(){
	$.ajax({
		url: '/doacoes/carregaCategoriasMenu',
		type: 'POST',
		dataType: 'json'
	})
	.done(function(data){
		for (var i = 0; i <= data.length-1; i++) {
			sel_categorias.append("<li id='"+data[i]['categoria_id']+"' class='list-group-item categ' >"+data[i]['categoria_nome']+"</li>");
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


$(document).ready(function(){

	
	todosEstados();
	todasCategorias();


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
        	filtraDoacoes();
    	}
	);

	/**
	 * Função para ao selecionar uma categoria retornar os itens 
	 * da categoria com base no id da cidade.
	 * 
	 */
	$(".categorias").on("click", ".categ", function(event) {
			/* chamar controle que carrega as doacoes filtradas */
			console.log($( this ).text());
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