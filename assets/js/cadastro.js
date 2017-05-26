var obrigatorio = ["nome", "email", "senha", "confirmacao", "estado", "cidade", "termos", "cpf", "cnpj"];

$(function(){
	// Mascara dos campos
	$('#input_cpf').mask('000.000.000-00', {reverse: true});
	$('#input_cnpj').mask('00.000.000/0000-00', {reverse: true});

	// Mudança na tela quando clica nos botões
	$("#tab_pessoa").on("click", function(){ btnChange(["pessoa", "cpf"], ["instituicao", "cnpj"]); });
	$("#tab_instituicao").on("click", function(){ btnChange(["instituicao", "cnpj"], ["pessoa", "cpf"]); });

	// Remove a classe de erro	
	obrigatorio.forEach(function(item, index){
		$("[name='" + item + "']").on("change", function(){ changeClass($(this), "remove"); });
	});
});

/* Ajax responsável por buscar as cidades correspondentes com o estado selecionado */
$("#select_estado").on("change", function(a){
	var estado 	= $(this).val();

	changeClass($(this), "remove");

	$("#select_estado").prop('disabled', true);
	$.ajax({
		url: "cadastro/selecionaCidades/" + estado,
		type: "POST",
		success: function(data){
			if(typeof JSON.parse(data) != "undefined"){
				var json = JSON.parse(data);

				if(typeof json["erro"] != "undefined"){
					$("#select_cidade option").remove();
					$('#select_cidade').prop('disabled', true);

					$("#group_mensagem").show();
					mensagem("erro", json["erro"], "mensagem");
				}else{
					$("#select_cidade option").remove();

					json["cidades"].forEach(function(item, index){
						$("#select_cidade").append('<option value="' + item["id"] + '">' + item["nome"] + '</option>');
					});

					$('#select_cidade').prop('disabled', false);
				}
			}

			$("#select_estado").prop('disabled', false);
		},
		error: function(data){
			$("#select_cidade option").remove();
			$('#select_cidade').prop('disabled', false);
		}
	}).done(function(){
		$('#select_estado').prop('disabled', false);
	});
});


/* Quando é dado submit no formulário, aqui ele é tratado e mandado por ajax */
$("#cadastroForm").on("submit", function(e){
    e.preventDefault();

    var flag = false;

    obrigatorio.forEach(function(item, index){
    	var obj = $('[name="' + item + '"]');

    	if(($.trim(obj.val()).length === 0)){
    		var sair = false;

    		if(item == "cpf" && !$("#radio_pessoa").prop("checked")) sair = true;
    		if(item == "cnpj" && !$("#radio_instituicao").prop("checked")) sair = true;

    		if(!sair){
    			changeClass(obj, "add");
	    		flag = true;
    		}
    	}else if(item == "termos" && !obj.prop("checked")){
			changeClass(obj, "add");
			flag = true;
    	}
    });

    if(!flag){
    	$.ajax({
			url: 'cadastro/salvarUsuario',
			type: 'POST',
			data: $("#cadastroForm").serialize(),
			dataType: "json",
			success: function(data){
				console.log(data);

				if(typeof data["erro"] != "undefined" && data["erro"].length > 0){
					mensagem("erro", data["erro"], data["campo"]);

					return;
				}

				
				$("#cadastroForm")[0].reset();

				mensagem("sucesso", "Oi, ainda não terminei isso... Ta inserindo no banco, mas alguns testes ainda não estão finalizados! =D", "mensagem");
				$("#div_mensagem").show();
			}
		});
    }else{
    	mensagem("erro", "Campos obrigatórios ainda não foram preenchidos.", "mensagem");
		$("#div_mensagem").show();
	}

	e.preventDefault();
});

/**
 * Faz as mudanças na tela quando é clicado nos botões em relação ao o tipo de usuário
 * @param  {array} to    Para qual botão será mudado, no formato: ["nomeDoBotão", "CampoASerMostrado"]
 * @param  {array} from  Qual botão deverá ser escondido, no formato: ["nomeDoBotão", "CampoASerEscondido"]
 * @return {void}
 */
function btnChange(to, from){
	if($("#radio_" + to[0]).prop("checked")) return;
	else{
		// $("#button_" + from[0]).removeClass("btn-primary").addClass("btn-info");
		// $("#button_" + to[0]).removeClass("btn-info").addClass("btn-primary");
		$("#li_" + to[0]).addClass("active");
		$("#li_" + from[0]).removeClass("active");
		$("#radio_" + to[0]).prop("checked", true);
		$("#div_" + to[1]).show();
		$("#div_" + from[1]).val("").hide();

		if(to[0] == "instituicao") $("#div_website").show();
		else $("#div_website").hide();
	}
}

/**
 * Modifica as classes dos objetos que são colocados como erros e para remover esses erros
 * @param  {html-object} obj Objeto a ser modificado
 * @param  {string} way Tipo de modificação, podendo ser remove ou add
 * @return {void}
 */
function changeClass(obj, way){
	var mainDiv = function(ini){
		var safetyCount = 0;
		while(true){
			if(safetyCount == 20) break;

			ini = ini.parent();
			if(ini.hasClass("form-group")) return ini;

			safetyCount += 1;
		}
	}

	if(way == "add") mainDiv(obj).addClass("has-error");
	else mainDiv(obj).removeClass("has-error");
}