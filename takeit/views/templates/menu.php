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
                    <a href="/painel">Meu Painel</a>
                </li>
                <li id="instituicoes">
                    <a href="/instituicoes">Instituições</a>
                </li>
                <li class="btn_menu" id="btn_doacao">
                    <div class="button text-center">
                        <a href="/doacoes/cadastrarItem">
                            <button type="button" class="btn btn-primary" action="">
                                <span class="fa fa-heart"></span> Fazer Doação
                            </button>
                        </a>
                    </div>
                </li>
                <li class="btn_menu" id="btn_sair">
                    <div class="button text-center">
                        <a href="/welcome">
                            <button type="button" class="btn btn-danger" action="">
                                <span class="fa fa-sign-out"></span>Sair
                            </button>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</header>