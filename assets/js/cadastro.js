$("#select_estado").on("change", function(a){
	var estado 	= $(this).val();

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
		}
	});
});





// $.ajax({
//    url: url,
//    type: "POST",
//    data: $("#cadastroForm").serialize(), // serializes the form's elements.
//    success: function(data){
//        alert(data); // show response from the php script.
//    }
//  });

// e.preventDefault(); // avoid to execute the actual submit of the form.