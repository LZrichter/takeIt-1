<footer id="footer" class="text-center">
	Copyright &copy Pineapple Solutions <img src="<?= base_url();?>assets/img/pineapple.png"> <?= date("Y"); ?>
</footer>
<!-- JS -->
	<script src="<?= base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?= base_url();?>assets/js/bootstrap.js"></script>
	<script src="<?= base_url();?>assets/js/main.js"></script>
	<? if(isset($js)): ?>
	<script src="<?= base_url();?>assets/js/<?=$js;?>"></script>
	<? endif;
	if(isset($js2)): ?>
	<script src="<?= base_url();?>assets/js/<?=$js2;?>"></script>
	<? endif; ?>
	<!-- DataTable -->
	<?php if(isset($dataTable)): ?>
		<script src="<?= base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?= base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
	<?php endif;?>
</body>
</html>