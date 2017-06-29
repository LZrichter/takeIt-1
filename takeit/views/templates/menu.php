<header>
<div id="main-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/doacoes">
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
                <li id="notificacao">
                    <button class="btn btn-lg btn-link">
                        <span class="fa fa-bell notify-bell"></span>
                        <span class="badge badge-notify">3</span>
                    </button>
                </li>
                <li id="painel">
                    <a href="/Painel">Meu Painel</a>
                </li>
                <li id="instituicoes">
                    <a href="/Instituicoes">Instituições</a>
                </li>
                <li id="fazer_doacoes">
                    <a href="/doacoes/cadastrarItem"><span class="fa fa-heart"></span> Fazer Doação</a>
                </li>
                <li id="sair">
                    <a href="/login/sair"><span class="fa fa-sign-out"></span>Sair</a>
                </li>
            </ul>
        </div>
    </div>
</div>
</header>