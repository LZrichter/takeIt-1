<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!'); ?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>
			<?= (isset($titulo) ? $titulo . " - takeIt" : "takeIt")?>
		</title>
	</head>
	<body>
		<div id="container">
			<center>
				<h1>Programa lalala!</h1>
			</center>

			<center>
				<h2>
					<?= (isset($teste) ? $teste : "Erro no teste"); ?>
				</h2>
			</center>
		</div>
	</body>
</html>