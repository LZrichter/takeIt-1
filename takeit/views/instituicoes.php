<div id="main">
	<ul class="breadcrumb">
	  <li><a href="/doacoes">Doações</a></li>
	  <li><a href="#">Instituições Beneficientes</a></li>
	</ul>

	<div class="container-fluid footer-align" id="container-instituicoes">
		<h3><span class="fa fa-building"></span> Instituiçoes Beneficientes</h3>
		<hr>
		
		<? if(isset($mensagem)){ ?>
			<div class="row">
				<div class="col-sm-12 text-center">
					<p class="bg-info">
						<h3><?= $mensagem; ?></h3>
					</p>
				</div>
			</div>
		<? } ?>

		
		<? if(isset($instituicoes) && count($instituicoes) > 0){ ?>
			<div class="table-responsive container" id="dic_table_div" style="width:100%">
				<table class="table table-responsive table-striped display text-center" id="instituicoes_table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Cidade</th>
							<th>UF</th>
							<th>Perfil</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($instituicoes as $num => $campos){ ?>
				            <tr>
				                <td><?= isset($campos["usuario_nome"]) ? $campos["usuario_nome"] : $campos["nome"]; ?></td>
				                <td><?= $campos["cidade_nome"]; ?></td>
				                <td><?= $campos["estado_uf"]; ?></td>
				                <td><a class="btn btn-success" href="/Usuario/visualizar/<?= $campos['usuario_id'] ?>">Ver Perfil</a></td>
				            </tr>							
						<? } ?>
			        </tbody>
				</table>
			</div>
		</div>
		<? } ?>
</div>
