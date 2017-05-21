<header>
<div id="main-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/welcome">
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
                <li class="btn_menu" id="btn_entrar">
                    <form action="login" method="post">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_login">
                            <span class="fa fa-sign-in"></span> Entrar
                        </button>
                    </form>
                </li>
                <li class="btn_menu" id="btn_cadastrar">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_cadastro">
                        <span class="fa fa-pencil-square-o"></span> Cadastre-se
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
</header>