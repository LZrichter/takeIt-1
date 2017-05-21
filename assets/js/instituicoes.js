$(document).ready(function{

	var instituicoes = $("#container-instituicoes");

	// $('#instituicoes_table').DataTable({
	//     "ajax": {
	//         "url": "ajax/dicionarioDataTable.php?action=alterar",
	//         "type": "po"
	//     },
	//    "order": [[ 1, "asc" ],[ 2, "asc" ]],
	//    "iDisplayLength": 5,
 //       "aLengthMenu": [[5, 10, 15, 20, 25, 50, 100, -1], [5, 10, 15, 20, 25, 50, 100, "All"]]
	// });
	
	$("#instituicoes_table").DataTable();
});