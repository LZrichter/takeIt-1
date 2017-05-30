<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Doacoes extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->model("CidadeEstado_model", "CEM");
		$this->load->model("Categoria_model", "CM");

	}

	public function index(){
		
		$dados["titulo"] = "Doações";
		$dados["css"]    = "menuDoacoes.css";
		$dados["css2"]   = "itens.css";
		$dados["js"]     = "menuDoacoes.js";

		// $this->load->model("inicio_model","ini");
		// $dados["teste"] = $this->ini->teste();
		// $this->load->model("usuario_model","user");

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('templates/menuDoacoes', $dados);
		$this->load->view('doacoes', $dados);
		$this->load->view('templates/footer');
	}
	
	public function item($id = 0){

		$dados["itemId"] = $id;
		$dados["titulo"] = "Doações";
		$dados["css"]    = "item.css";
		$dados["js"]    = "imageZoom.js";

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('item', $dados);
		$this->load->view('templates/footer');
	}

	public function cadastrarItem(){

		$dados["titulo"] = "Cadastrar Item";
		$dados["css"]    = "item.css";
		$dados["js"]     = "ajaxUploadFile.js";
		$dados["js2"]     = "doacao.js";

		$dados["categorias"] = $this->CM->buscaCategorias();

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('doacao', $dados);
		$this->load->view('templates/footer');
	}

	public function teste(){

		foreach($_REQUEST as $k => $v)//transforma os requests em variaveis
		 	$$k = $v;
		
		$dados = $_REQUEST;
		// echo json_encode($dados);
		// return;
		
		$obrigatorio = [
			"descricao", "categoria", "quantidade", 
			"detalhes"
		];

		$return = array();
		$erro = 1;
		/* Validação dos Campos */
		foreach($obrigatorio as $campo){
			if(!in_array($campo, array_keys($dados)) || (isset($dados[$campo]) && empty(trim($dados[$campo])))){
				if ($campo == 'quantidade' && $dados['quantidade'] <= 0) {
					array_push($return, ["tipo" => "erro", "msg" => "O campo<b> $campo.</b> deve ser maior que zero!", "campo" => $campo]);	
				}else{
					array_push($return, ["tipo" => "erro", "msg" => "Por favor, preencha o campo<b> $campo.</b>", "campo" => $campo]);	
				}
				$erro = 1;
			}else if($campo === 'categoria' && $dados["categoria"] === "Selecione..."){
				array_push($return, ["tipo" => "erro", "msg" => "Por favor selecione uma <b> $campo.</b>", "campo" => $campo]);	
				$erro = 1;
			}else{ //sucesso na validacao
				array_push($return, ["tipo" => "sucesso", "msg" => "", "campo" => $campo]);
				$erro = 0;
			}
		}
		
		if ($erro) { // se der erro retornar resposta para a pagina principal
			echo json_encode($return);
		}else{
			/*
			* TODO 
			* fazer validação das imagens
			* fazer upload das imagens
			* salvar item no banco
			* pegar o id do item no banco
			* salvar imagens no banco com o id do item
			*/
			
			date_default_timezone_set('America/Sao_Paulo');

			$desc = preg_replace('/\s+/', '', $descricao);

			$path = "./assets/img/uploads/".date("Y")."/".date("m")."/".date("d")."/".$desc.date("H.i.s");
	
			$dirname = iconv("UTF-8","Windows-1252",$path);
	
			if (!is_dir($dirname)) { //cria o diretorio para uploads se ele ja não existir
				mkdir($dirname, 0777, true);
			}

			for ($i = 1; $i <= 5; $i++){
				if (!empty($_FILES["imagem$i"]['name'])) {
					
					$config['upload_path']      = $dirname;
	        		$config['allowed_types']    = 'gif|jpg|png';
	        		$config['encrypt_name']		= TRUE;
	        		$config['overwrite']		= TRUE;
	        		$config['max_size']         = 100; //Kb
	        		// $config['max_width']            = 1024;
	        		// $config['max_height']           = 768;
	        		
	        
	        		$this->load->library('upload', $config);
	        		$this->upload->initialize($config);
	            	if(!$this->upload->do_upload("imagem$i")){ //deu errado o upload
	                	array_push($return, ["msg" => $this->upload->display_errors(), "tipo" => "erro", "campo" => "fotos"]);
	                	// rmdir($dirname);
	                	echo json_encode($return);
	                	
	            	}else{ // deu certo o upload
	            		$success = $this->upload->data();
	            		array_push($return,["msg" => $success, "tipo" => "sucesso", "path" => $success['file_path']]);
	            		echo json_encode($return);

	            		// $uploadData['file_name'] = $fileData['file_name'];
	                	// $uploadData['created'] = date("Y-m-d H:i:s");
	                	// $uploadData['modified'] = date("Y-m-d H:i:s");
	            		
	            	}	
				}
			}
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

	public function filtraDoacoes($idCategoria, $idCidade){
		/*
		* TODO
		* filtra doaçoes pela categoria e cidade pelo menu lateral 
		*/
	
		

	}
}
