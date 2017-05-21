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
                    <div class="button text-center">
                        <a href="/login">
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-sign-in"></i> Entrar
                            </button>
                        </a>
                    </div>
                </li>
                <li class="btn_menu" id="btn_cadastrar">
                    <div class="button text-center">
                        <a href="/cadastro">
                            <button type="button" class="btn btn-success">
                                <i class="fa fa-pencil-square-o"></i> Cadastre-se
                            </button>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</header>