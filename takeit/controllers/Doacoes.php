<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Doacoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('login');
		$this->load->library('session');

		testaLogin();

		$this->load->model("CidadeEstado_model", "CEM");
		$this->load->model("Categoria_model", "CM");
		$this->load->model('Item_model', 'IM');
		$this->load->model('Imagem_model', 'IMG');
		$this->load->model('Usuario_model', 'UM');
	}

	public function index($indice = 1){

		if(isset($_POST["busca"])){
			$busca = $_POST["busca"];
		} else {
			$busca = "";
		}

		$this->session->set_userdata("indice", $indice);

		$dados["titulo"] = "Doações";
		$dados["css"]    = "menuDoacoes.css";
		$dados["css2"]   = "doacoes.css";
		$dados["js"]     = "menuDoacoes.js";
		$dados["js2"]	 = "doacoes.js";

		$dados["indice"] = $this->session->userdata('indice');
		$dados["cidade_id"] = $this->session->userdata('cidade_filtro');
		$dados["categoria_id"] = $this->session->userdata('categoria');
		$dados["busca"] = $busca;
		$dados["usuario_id"] = $this->session->userdata('user_id');

		$dados["itens"] = $this->IM->buscaItensCidade($dados);

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('templates/menuDoacoes', $dados);
		$this->load->view('doacoes', $dados);
		$this->load->view('templates/footer');
	}
	
	public function item($id = NULL){

		$dados["itemId"] = $id;
		$dados["titulo"] = "Doações";
		$dados["css"]    = "item.css";
		$dados["js"]    = "item.js";

		$dados["item"] = $this->IM->buscaItemPorId($id);
		$dados["categoria"] = $this->CM->buscaCategoriaPorId($dados["item"][0]["categoria_id"]);;
		$dados["imagens"] = $this->IMG->buscaImagensPorItem($id);
		$dados["user_id"] = $this->session->userdata('user_id');

		$dados["dadosDoador"] = $this->UM->buscaUsuario(array('id' => $dados['item'][0]['usuario_id'] ), TRUE);
		$this->load->model('Interesse_model', 'inter');
		$dados["interessado"] = $this->inter->testaInteresseItem($dados['item'][0]['item_id'], $dados["user_id"]);

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('item', $dados);
		$this->load->view('templates/footer');
	}

	public function cadastrarItem(){

		$dados["titulo"] = "Cadastro de Doação";
		$dados["css"]    = "item.css";
		$dados["js"]     = "ajaxUploadFile.js";
		$dados["js2"]     = "doacao.js";

		$dados["categorias"] = $this->CM->buscaCategorias();
		$dados["user_id"] = $this->session->userdata('user_id');

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('doacao', $dados);
		$this->load->view('templates/footer');
	}

	public function cadastraItemAjax(){
		//transforma os requests em variaveis
		foreach($_REQUEST as $k => $v)
		 	$$k = $v;
		
		$dados = $_REQUEST;
		
		$obrigatorio = [ "descricao", "categoria", "quantidade", "detalhes" ];

		$return = array(); // AJAX Response
		$dadosImg = array(); //Dados das imagens
		/* Validação dos Campos */
		foreach($obrigatorio as $campo){
			if(!in_array($campo, array_keys($dados)) || (isset($dados[$campo]) && empty(trim($dados[$campo])))){
					array_push($return, ["tipo" => "erro", "msg" => "Por favor, preencha o campo<b> $campo.</b>", "campo" => $campo]);	
			}else if($campo === 'categoria' && $dados["categoria"] === "Selecione..."){
				array_push($return, ["tipo" => "erro", "msg" => "Por favor selecione uma <b> $campo.</b>", "campo" => $campo]);	
			}else if ($campo == 'quantidade' && $dados['quantidade'] <= 0 ){
					array_push($return, ["tipo" => "erro", "msg" => "O campo<b> $campo.</b> deve ser maior que zero!", "campo" => $campo]);	
			}else{ //sucesso na validacao
				array_push($return, ["tipo" => "sucesso", "campo" => $campo]);
			}
		}
		
		date_default_timezone_set('America/Sao_Paulo');

		$desc = preg_replace('/\s+/', '', $descricao);
		$path = "./assets/img/uploads/".date("Y")."/".date("m")."/".date("d")."/".$desc.date("H.i.s");
		
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
			$dirname = iconv("UTF-8","Windows-1252",$path);
		else
		    $dirname = iconv("UTF-8","UTF-8",$path);

		//cria o diretorio para uploads se ele ja não existir
		if (!is_dir($dirname))
			mkdir($dirname, 0777, true);

		for ($i = 1; $i <= 5; $i++){
			if (!empty($_FILES["imagem$i"]['name'])) {
				
				$config['upload_path']      = $dirname;
        		$config['allowed_types']    = 'gif|jpg|png|jpeg';
        		$config['encrypt_name']		= TRUE;
        		$config['overwrite']		= TRUE;
        		$config['max_size']         = 2048; //Kb
        		// $config['max_width']            = 1024;
        		// $config['max_height']           = 768;
        
        		$this->load->library('upload', $config);
        		$this->upload->initialize($config);
            	if(!$this->upload->do_upload("imagem$i")){ //deu erro no upload
                	array_push($return, ["msg" => $this->upload->display_errors(), "tipo" => "erro", "campo" => "fotos"]);
                	$apagarPasta = 1;
            	}else{ // deu certo o upload
            		$success = $this->upload->data();
            		array_push($return,["tipo" => "sucesso", "campo" => "fotos"]);

            		array_push($dadosImg, ["imagem_nome" => $success['file_name'], "imagem_caminho" => $path, "imagem_tamanho" => $success['file_size'] ]);
            		
            	}	
			}
		}
		if (isset($apagarPasta)){
			foreach(scandir($dirname) as $file) {
		        if ('.' === $file || '..' === $file) continue;
		        if (is_dir("$dirname/$file")) rmdir_recursive("$dirname/$file");
		        else unlink("$dirname/$file");
		    }
			rmdir($dirname);
		}
		else{ //SALVAR TUDO NO BANCO, ITEM PRIMEIRO IMAGENS DEPOIS
			$this->load->model('Item_model', 'IM');
			$this->db->trans_begin();
			$itemReturn = $this->IM->insereItem($dados);
			if($itemReturn["tipo"] == "sucesso" && isset($itemReturn["idItem"])){ //SALVAR IMAGENS
				$this->load->model('Imagem_model', 'IMG');
				array_push($return, $itemReturn);
				foreach($dadosImg as $row => $value){
					$dadosImg[$row] = array_merge($dadosImg[$row], ["item_id" => $itemReturn["idItem"]]);
					
					$insertImage = $this->IMG->insereImagem($dadosImg[$row]);
					if(!$insertImage && $this->db->trans_status() === FALSE){ //deu errado a imagem
						array_push($return, $insertImage);
						$this->db->trans_rollback(); //rollback no banco
						rmdir($dirname);
						break;
					}
				}	
				
				$this->db->trans_commit();
			}
		}
		echo json_encode($return);
		return;	
	}

	public function alterarItem($idItem = NULL){
		$dados["titulo"] = "Alterar Doação";
		$dados["css"]    = "item.css";
		$dados["js"]     = "ajaxUploadFile.js";
		$dados["js2"]    = "doacao.js";

		$dados["categorias"] = $this->CM->buscaCategorias();
		$dados["user_id"] = $this->session->userdata('user_id');
		$dados["item"] = $this->IM->buscaItemPorId($idItem);
		$dados["item_categoria"] = $this->CM->buscaCategoriaPorId($dados['item'][0]['categoria_id']);
		$dados["imagens"] = $this->IMG->buscaImagensPorItem($idItem);
		$dados["alterar"] = TRUE;

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('doacao', $dados);
		$this->load->view('templates/footer');
	}

	public function alteraItemAjax(){
		//transforma os requests em variaveis
		foreach($_REQUEST as $k => $v)
		 	$$k = $v;
		
		$dados = $_REQUEST;
		
		$obrigatorio = ["descricao", "categoria", "quantidade", "detalhes"];

		$return = array(); // AJAX Response
		$dadosImg = array(); //Dados das imagens

		/* Validação dos Campos */
		foreach($obrigatorio as $campo){
			if(!in_array($campo, array_keys($dados)) || (isset($dados[$campo]) && empty(trim($dados[$campo])))){
					array_push($return, ["tipo" => "erro", "msg" => "Por favor, preencha o campo<b> $campo.</b>", "campo" => $campo]);	
			}else if($campo === 'categoria' && $dados["categoria"] === "Selecione..."){
				array_push($return, ["tipo" => "erro", "msg" => "Por favor selecione uma <b> $campo.</b>", "campo" => $campo]);	
			}else if ($campo == 'quantidade' && $dados['quantidade'] <= 0 ){
					array_push($return, ["tipo" => "erro", "msg" => "O campo<b> $campo.</b> deve ser maior que zero!", "campo" => $campo]);	
			}else{ //sucesso na validacao
				array_push($return, ["tipo" => "sucesso", "campo" => $campo]);
			}
		}

		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
			$dirname = iconv("UTF-8","Windows-1252",$dados['oldPath']);
		else
		    $dirname = iconv("UTF-8","UTF-8",$dados['oldPath']);
		
		// Quer dizer que ao menos uma imagem foi alterada ou adicionada
		if ($alterouImagem == 1) {
			$oldFotos = explode(",", $dados['oldFotos']);
			for ($i = 1; $i <= 5; $i++){
				if (!empty($_FILES["imagem$i"]['name'])) {
					$config['upload_path']      = $dirname;
    				$config['allowed_types']    = 'gif|jpg|png|jpeg';
    				$config['encrypt_name']		= TRUE;
    				$config['overwrite']		= TRUE;
    				$config['max_size']         = 2048; //Kb

    				if (isset($oldFotos[$i-1])) { //subustituir foto na pasta com o mesmo nome
    					$config['encrypt_name']	= FALSE;
    					$config['file_name'] = $oldFotos[$i-1]; //seta o mesmo nome pra foto

    					$this->load->library('upload', $config);
    					$this->upload->initialize($config);
        				
        				if(!$this->upload->do_upload("imagem$i")){ //deu errado o upload
            				array_push($return, ["msg" => $this->upload->display_errors(), "tipo" => "erro", "campo" => "fotos"]);
            				$erroNaImagem = 1;
        				}else{ // deu certo o upload
        					$success = $this->upload->data();
        					array_push($return,["tipo" => "sucesso", "campo" => "fotos"]);
        				}
    				}else{
    					$config['encrypt_name']	= TRUE;
    					$imagemNova = 1;

    					$this->load->library('upload', $config);
    					$this->upload->initialize($config);

    					if(!$this->upload->do_upload("imagem$i")){ //deu errado o upload
            				array_push($return, ["msg" => $this->upload->display_errors(), "tipo" => "erro", "campo" => "fotos"]);
            				$erroNaImagem = 1;
        				}else{ // deu certo o upload
        					$success = $this->upload->data();
        					array_push($return,[ "tipo" => "sucesso", "campo" => "fotos"]);

        					array_push($dadosImg, ["imagem_nome" => $success['file_name'], "imagem_caminho" => $dirname, "imagem_tamanho" => $success['file_size'], "item_id" => $idItem ]);
        				}
        				
    				}
    			}
			}
			
			if (!isset($erroNaImagem)) {
				$this->db->trans_begin();
				$r = $this->IM->alteraItem($dados);
				if ($r !== TRUE) {
					array_push($return, $r);
				}else{
					if (isset($imagemNova) && $imagemNova == 1) { // se imagem nova inserir no banco
						foreach($dadosImg as $row => $value){
							$insertImage = $this->IMG->insereImagem($dadosImg[$row]);
							if(!$insertImage && $this->db->trans_status() === FALSE){ //deu errado a imagem
								array_push($return, $insereImage);
								$this->db->trans_rollback(); //rollback no banco
								break;
							}
						}
					}	
					if($this->db->trans_commit())
						array_push($return, ["tipo" => "sucesso", "msg" => "Doação alterada com sucesso!"]);
				}
			}
			
			
		}else{ //não alterou nenhuma imagem
			if (!$r = $this->IM->alteraItem($dados))
				array_push($return, $r);
			else
				array_push($return, ["tipo" => "sucesso", "msg" => "Doação alterada com sucesso!"] );
		}

		echo json_encode($return);
	}

	public function cancelaItemAjax(){
		if (isset($_POST['idItem'])) {
			
			$idItem = $_POST['idItem'];
			$result = $this->IM->alteraStatusItemPorId($idItem, 'Cancelado');

			if ($result)
				echo json_encode(["tipo" => "sucesso", "msg" => "Seu item foi removido com sucesso"]);
			else
				echo json_encode($result);
		}
	}

	public function denunciaItemAjax(){
		if (isset($_POST["item_vacilao"]) && isset($_POST['usuario_vacilao']) && isset($_POST['usuario_x9']) && isset($_POST['denuncia_text'])) {
			
			foreach($_POST as $k => $v)
		 		$$k = $v;

		 	$this->load->model("Denuncia_model", "DM");
		 	$result = $this->DM->insereDenuncia(
		 		array(
		 			'denuncia_text' => $denuncia_text,
		 			'usuario_xnove' => $usuario_x9,
		 			'usuario_vacilao' => $usuario_vacilao,
		 			'item_vacilao' => $item_vacilao
		 		)
		 	);

		 	if ($result) {
		 		echo json_encode(["tipo" => "sucesso", "msg" => "Sua Denúncia foi reportada ao Administrador para uma avaliação. Obrigado por ajudar <span class='fa fa-heart'></span> "]); 
		 	}else{
		 		echo json_encode($result);
		 	}
		}
	}

	public function interesse(){
		$acao    = $this->input->post()["acao"];
		$item_id = $this->input->post()["item_id"];
		$user_id = $this->session->userdata('user_id');

		$this->load->model("Interesse_model", "inter");
		$this->load->model("Item_model", "item");
		
		if($acao=="adicionar"){
			$resposta = $this->inter->manifestarInteresse($item_id, $user_id);
			$interessados = $this->inter->todosInteressados($item_id);

			if($resposta["tipo"]=="sucesso" && count($interessados)>0)
				$resposta = $this->item->alteraStatusItemPorId($item_id,"Solicitado");
		
		}else if($acao=="remover"){
			$resposta = $this->inter->removerInteresse($item_id, $user_id);
			$interessados = $this->inter->todosInteressados($item_id);
			$ninguem = "Nenhuma pessoa demonstrou interesse no seu item ainda.";

			if($resposta["tipo"]=="sucesso"  && isset($interessados["msg"]) && $interessados["msg"]==$ninguem)
				$resposta = $this->item->alteraStatusItemPorId($item_id,"Disponível");

		}else{
			$resposta = ["tipo" => "erro", "msg" => "Ocorreu um erro inesperado no sistema. Tente contatar o suporte@takeit.com.br que iremos ajuda-lo."];
		}

		echo json_encode($resposta);
		return;
	}

	public function agradecimentoAjax(){
		if (isset($_POST['id_interesse'])){
			
			$this->load->model("Doacao_model", "DM");
			
			$return = $this->DM->agradecerDoacao($_POST['id_interesse']);
			
			if($return)
				echo json_encode(["tipo" => "sucesso", "msg" => "Seu agradecimento foi realizado com sucesso! "]);
			else
				echo json_encode($return);
		}
	}

	public function carregaEstadosMenu(){
		$dados = $this->CEM->todosEstados();
		echo( json_encode($dados) );
	}

	public function carregaMunicipiosMenu($idEstado){
		$dados = $this->CEM->selecionaCidades($idEstado);
		echo( json_encode($dados) );
	}

	public function carregaCategoriasMenu(){
		$dados = $this->CM->buscaCategorias();
		echo( json_encode($dados) );
	}

	public function setEstado($idEstado){
		$this->session->set_userdata("estado_filtro", $idEstado);
		echo( json_encode($idEstado) );
	}

	public function setSessaoCidade($idCidade){
		$this->session->set_userdata("cidade_filtro", $idCidade);
		echo( json_encode($idCidade) );
	}

	public function setSessaoCategoria($idCategoria){
		if($idCategoria == $this->session->userdata('categoria')){
			$this->session->set_userdata("categoria", 0);
		} else {
			$this->session->set_userdata("categoria", $idCategoria);
		}
		
		
		echo( json_encode($idCategoria) );
	}

	public function setIndice($indice){
		$this->session->set_userdata("indice", $indice);
		echo( json_encode($indice) );
	}

}
