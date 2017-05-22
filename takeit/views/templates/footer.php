<footer id="footer" class="text-center">
	Copyright &copy Pineapple Solutions <img src="<?= base_url();?>assets/img/pineapple.png"> <?= date("Y"); ?>
</footer>
<!-- JS -->
	<script src="<?= base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?= base_url();?>assets/js/bootstrap.js"></script>
	<script src="<?= base_url();?>assets/js/<?= (isset($js) ? $js : "")?>"></script>
	<script src="<?= base_url();?>assets/js/<?= (isset($js2) ? $js2 : "")?>"></script>
<!-- DataTable -->
	<?php if(isset($dataTable)): ?>
		<script src="<?= base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?= base_url();?>assets/js/dataTables.bootstrap.js"></script>
	<?php endif;?>
</body>
</html>