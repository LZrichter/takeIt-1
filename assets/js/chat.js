$('[name="userButton"]').on("click", function(){
	console.log($(this).data("user"));
	console.log("Clicado");

	$.ajax({
		url: "chat/chatMeio",
		type: "POST",
		success: function(data){
			console.log(data);
			$("#painelMsgs").html(data);
		}
	});
});