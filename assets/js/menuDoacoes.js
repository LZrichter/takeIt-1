$(document).ready(function(){
	
	var  $subMenu1 = $('#submenu-1');
	var  $subMenu2 = $('#submenu-2');
	var  $municipios = $('#sel2');

	/* IF para telas menores do 767px */
	if ($(window).width() < 992) {
		$subMenu1.removeClass("in");
		$subMenu2.removeClass("in");
		$municipios.css("width", "85px");
	}else{
		$subMenu1.addClass("in");
		$subMenu2.addClass("in");
		$municipios.css("width", "100px");
	}

	$(window).resize(function() { //detecta o redimensionamento da tela do navegador
  		if ($(this).width() >= 992) {
  			$subMenu1.addClass("in");
  			$subMenu2.addClass("in");
  		}else{
  			$subMenu1.removeClass("in");
  			$subMenu2.removeClass("in");
  			$municipios.css("width", "85px");
  		}
	});
});