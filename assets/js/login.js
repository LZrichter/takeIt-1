$(document).ready(function(){
	
	var  $wellCols = $('.well');

	/* IF para telas menores do 767px */
	if ($(window).width() < 767) {
		$wellCols.removeClass("col-xs-offset-3");
		$wellCols.removeClass("col-xs-6");
	}else{
		$wellCols.addClass("col-xs-offset-3");
		$wellCols.addClass("col-xs-6");
	}

	$(window).resize(function() { //detecta o redimensionamento da tela do navegador
  		if ($(this).width() >= 767) {
  			$wellCols.addClass("col-xs-offset-3");
  			$wellCols.addClass("col-xs-6");
  		}else{
  			$wellCols.removeClass("col-xs-offset-3");
  			$wellCols.removeClass("col-xs-6");
  		}
	});
});