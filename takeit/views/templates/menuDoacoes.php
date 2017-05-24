<div id="mySidenav" class="sidenav"> 
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>   
    <p class="sidenav-itens">
        <ul class="list-group">
        <li class="list-group-item active">
            Localização <span class="fa fa-map-marker pull-right"></span>
        </li>
            <li class="list-group-item">
                <div class="form-group">
                    <label for="sel-estado">Estado: </label>
                    <select class="estados form-control" id="sel-estado">
                            <!-- Ajax carrega os Estados -->
                    </select>    
                </div>
                
            </li>
            <li class="list-group-item">
                <label for="sel-municipio">Município: </label>
                <select class="municipios form-control" id="sel-municipio">
                    <!-- Ajax Carrega os municipios com base nos estados -->
                </select>
            </li>
        </ul>
    </p>
    <p class="sidenav-itens">
        <ul class="list-group">
            <li class="list-group-item active">
                Categorias <span class="fa fa-list pull-right"></span>
            </li>
            <li class="list-group-item"><a href="#"> Roupas</a></li>
            <li class="list-group-item"><a href="#"> Roupas</a></li>
            <li class="list-group-item"><a href="#"> Roupas</a></li>
            <li class="list-group-item"><a href="#"> Roupas</a></li>
            <li class="list-group-item"><a href="#"> Roupas</a></li>
            <li class="list-group-item"><a href="#"> Roupas</a></li>
            <li class="list-group-item"><a href="#"> Roupas</a></li>
        </ul>         
    </p>
</div>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
        
