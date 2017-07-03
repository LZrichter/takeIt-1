<header>
<?
    $tipo_usuario = $this->session->userdata('user_tipo');
?>
<div id="main-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<? echo $tipo_usuario == 'Pessoa' ? "/doacoes" : "#" ?>">
                <img id="logo" src="<?= base_url();?>assets/img/logo.png">
            </a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-menubuilder">
            <ul class="nav navbar-nav navbar-right">
                <? if($tipo_usuario == 'Pessoa'): ?>
                    <li id="notificacao">
                        <button class="btn btn-lg btn-link">
                            <a href="<?= base_url();?>Doacoes/notificacao">
                                <span class="fa fa-bell notify-bell"></span>
                                <span class="badge badge-notify">3</span>
                            </a>
                        </button>
                    </li>
                <? endif; ?>
                <li id="painel">
                    <a href="/Painel">Meu Painel</a>
                </li>
                <li id="instituicoes">
                    <a href="/Instituicoes">Instituições</a>
                </li>
                <? if($tipo_usuario == 'Pessoa'): ?>
                    <li id="fazer_doacoes">
                        <a href="/doacoes/cadastrarItem"><span class="fa fa-heart"></span> Fazer Doação</a>
                    </li>
                <? endif; ?>
                <li id="sair">
                    <a href="/login/sair"><span class="fa fa-sign-out"></span>Sair</a>
                </li>
            </ul>
        </div>
    </div>
</div>
</header>