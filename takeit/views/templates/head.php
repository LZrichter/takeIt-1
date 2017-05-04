
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/menu.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/footer.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/<?= (isset($css) ? $css : "style")?>">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.min.css">
		<!-- FAVICON -->
		<link rel="icon" type="image/png" href="assets/img/favicon.png">
		<!-- JS -->
		<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
		<title>
			<?= (isset($titulo) ? $titulo . " - takeIt" : "takeIt")?>
		</title>
	</head>
	<body>