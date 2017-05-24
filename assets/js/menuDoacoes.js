var sel_estado = $('.estados');

function todosEstados(){
	$.ajax({
		url: '/doacoes/carregaEstadosMenu',
		type: 'POST',
		dataType: 'json',
	})
	.done(function(msg) {
		console.log("Total de estados: "+msg.length);
		for (var i = 0; i <= msg.length-1; i++) {
			sel_estado.append("<option id='"+msg[i]['id']+"' >"+msg[i]['uf']+"</option>");
		}
	})
	.fail(function() {
		console.log("error ao preencher o menu de estados");
	});
		
}




$(document).ready(function(){

	todosEstados();
	
	var  $menu_localizacao = $('#submenu-localizacao');
	var  $menu_categorias = $('#submenu-categorias');


	/* IF para telas menores do 767px */
	if ($(window).width() < 992) {
		$menu_localizacao.removeClass("in");
		$menu_categorias.removeClass("in");
	}else{
		$menu_localizacao.addClass("in");
		$menu_categorias.addClass("in");
	}

	$(window).resize(function() { //detecta o redimensionamento da tela do navegador
  		if ($(this).width() >= 992) {
  			$menu_localizacao.addClass("in");
  			$menu_categorias.addClass("in");
  		}else{
  			$menu_localizacao.removeClass("in");
  			$menu_categorias.removeClass("in");
  		}
	});
});