$(function(){
	$('#input_cpf').mask('000.000.000-00', {reverse: true});
	$('#input_cnpj').mask('00.000.000/0000-00', {reverse: true});

	$("#button_pessoa").on("click", function(){ 
		btnChange(["pessoa", "cpf"], ["instituicao", "cnpj"]);
	});

	$("#button_instituicao").on("click", function(){ 
		btnChange(["instituicao", "cnpj"], ["pessoa", "cpf"]);
	});
});

/* Ajax responsável por buscar as cidades correspondentes com o estado selecionado */
$("#select_estado").on("change", function(a){
	var estado 	= $(this).val();

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

$("#cadastroForm").on("submit", function(e){
    e.preventDefault();

    var obrigatorio = ["nome", "email", "senha", "confirmacao", "estado", "cidade", "termos"], flag = false;

    obrigatorio.forEach(function(item, index){
    	if($.trim($('[name="' + item + '"]').val()).length === 0){
    		var mainDiv = function(ini){
    			while(true){
    				ini = ini.parent();
    				if(ini.hasClass("form-group")) return ini;
    			}
    		}

    		mainDiv($('[name="' + item + '"]')).addClass("has-error");
    		flag = true;
    	}
    });

	$.ajax({
		url: 'cadastro/salvarUsuario',
		type: 'POST',
		data: $("#cadastroForm").serialize(),
		dataType: "json",
		success: function(data){
			console.log(data);

			mensagem("sucesso", "Oi, ainda não terminei isso... Não ta inserindo no banco, mas algumas coisas estão funcionando já!", "mensagem");
			$("#div_mensagem").show();
		}
	});

	e.preventDefault();
});

/**
 * Faz as mudanças na tela quando é clicado nos botões em relação ao o tipo de usuário
 * @param  {array} to    Para qual botão será mudado, no formato: ["nomeDoBotão", "CampoASerMostrado"]
 * @param  {array} from  Qual botão deverá ser escondido, no formato: ["nomeDoBotão", "CampoASerEscondido"]
 * @return {void}
 */
function btnChange(to, from){
	console.info("To: ");
	console.log(to);
	console.info("From: ");
	console.log(from);
	if($("#radio_" + to[0]).prop("checked")) return;	
	else{
		$("#button_" + from[0]).removeClass("btn-primary").addClass("btn-info");
		$("#button_" + to[0]).removeClass("btn-info").addClass("btn-primary");
		$("#radio_" + to[0]).prop("checked", true);
		$("#div_" + to[1]).show();
		$("#div_" + from[1]).val("").hide();

		if(to[0] == "instituicao") $("#div_website").show();
		else $("#div_website").hide();
	}
}

// $.ajax({
//    url: url,
//    type: "POST",
//    data: $("#cadastroForm").serialize(), // serializes the form's elements.
//    success: function(data){
//        alert(data); // show response from the php script.
//    }
//  });

// e.preventDefault(); // avoid to execute the actual submit of the form.