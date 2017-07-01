<div class="footer-align" id="main">
	<ul class="breadcrumb">
	  <li><a href="/painel">Painel</a></li>
	  <li><a href="#"><?= $titulo ?></a></li>
	</ul>

	<div class="container-fluid footer-align" id="container-dados">
		<h3><span class="fa fa-building"></span>  <?= $titulo ?></h3>
		<hr>
		
		<? if(isset($dados) && count($dados) > 0){ ?>
			<div class="table-responsive container" id="dic_table_div" style="width:100%">
				<table class="table table-responsive table-striped display text-center" id="dados_table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<? 
							foreach($dados as $row => $innerArray){
  								foreach($innerArray as $innerRow => $value){
    								echo "<th>".$innerRow."</th>";
  								}
  								break;
							} ?>
						</tr>
					</thead>
					<tbody>
						<? 
							foreach($dados as $row => $innerArray){
								echo "<tr>";
  								foreach($innerArray as $innerRow => $value){
    								echo "<td>".$value."</td>";
  								}
  								echo "</tr>";
						} ?>
			        </tbody>
				</table>
			</div>
		<? }else{ ?>
			<div class="alert alert-warning text-center">
				<div class="row">
					<div class="col-md-6 col-md-offset-3"><h3>Opps! Você ainda não tem nada por aqui. <span class="fa fa-frown-o"></span></h3>
					</div>
				</div>
			</div>
		<? } ?>
	</div>
</div>
