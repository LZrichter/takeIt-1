<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Usuario extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		
		$this->load->helper('login');
		testaLogin();
	}

	public function index(){
		$dados["titulo"] = "Usuário";
		$dados["js"]	 = "jquery.mask.js";

		$this->load->model('Usuario_model', 'user');
		$res = $this->user->selecionaUsuario(1, true);

		$dados["dado"] = $this->user->erro;
		$dados["nome"] = $res["nome"];

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu');
		$this->load->view('usuario', $dados);
		$this->load->view('templates/footer');
	}

	/**
	 * Busca todos os dados do usuário e carrega a view que os exibe
	 * @return void
	 */
	public function perfil(){
		$dados["css"]  = "painel.css";
		$dados["js"]   = "jquery.mask.js";
		$dados["js2"]  = "ajaxUploadFile.js";
		$dados["js3"]  = "perfil.js";

		$this->load->model('Usuario_model', 'user');
		$dados["usuario"] = $this->user->selecionaUsuario($this->session->userdata('user_id'), TRUE);

		$this->load->model("CidadeEstado_model", "CEM");
		$dados["estados"] = $this->CEM->todosEstados();
		$dados["cidades"] = $this->CEM->selecionaCidades($dados['usuario']['estado_id']);

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('perfil', $dados);
		$this->load->view('templates/footer');
	}

	/**
	 * Salva os dados do perfil usuário preenchidos no formulário
	 * @return void Da echo em um json de resultado
	 */
	public function alterarPerfil(){
		$dados = $this->input->post();
		foreach($dados as $key => $value)
			$$key = $value;

		$resposta = array(); // AJAX Response
		$dadosImg = array(); //Dados das imagens

		$user_tipo = $this->session->userdata('user_tipo');
		$user_id = $this->session->userdata('user_id');

		if($user_tipo == "Pessoa"){
			$this->load->model("Pessoa_model", "pessoa");
			$resposta = $this->pessoa->alteraPessoa($user_id, $dados);
		}else{
			$this->load->model("Instituicao_model", "instituicao");
			$resposta = $this->instituicao->alteraInstituicao($user_id, $dados);
		}
		
		if($resposta["tipo"]=="sucesso" && isset($flag_foto)){
			$folder = preg_replace('/\s+/', '', $nome.$user_id);
			$path = "./assets/img/users/".$folder;
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
				$dirname = iconv("UTF-8","Windows-1252",$path);
			else
			    $dirname = iconv("UTF-8","UTF-8",$path);

			//cria o diretorio para uploads se ele ja não existir
			if (!is_dir($dirname))
				mkdir($dirname, 0777, true);

			if (!empty($_FILES["foto"]['name'])) {
				$config['upload_path']		= $dirname;
				$config['allowed_types']	= 'gif|jpg|png|jpeg';
				$config['overwrite']		= TRUE;
				$config['max_size']			= 2048; //KB

				// Verifica se já existe uma foto, se já existe mantem o mesmo nome
				if($old_foto!=''){
					$config['encrypt_name']	= FALSE;
					$config['file_name'] = $old_foto;
				// Se ainda não existe insere uma nova
				}else{
					$config['encrypt_name']		= TRUE;
					$imagemNova = 1;
				}

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if(!$this->upload->do_upload("foto")) // Erro no upload
					$erroNaImagem = 1;
				else{ // Upload OK
					$success = $this->upload->data();
					$dadosImg["imagem_nome"] = $success['file_name'];
					$dadosImg["imagem_caminho"] = $path;
					$dadosImg["imagem_tamanho"] = $success['file_size'];
				}
			}

			if (isset($erroNaImagem) && $old_foto==''){
				foreach(scandir($dirname) as $file) {
					if ('.' === $file || '..' === $file) continue;
					if (is_dir("$dirname/$file")) rmdir_recursive("$dirname/$file");
					else unlink("$dirname/$file");
				}
				rmdir($dirname);
				$resposta = ["msg" => $this->upload->display_errors(), "tipo" => "erro", "campo" => "fotos"];
				echo json_encode($resposta);
				return;

			}else if($old_foto==''){
				$dadosImg["item_id"] = "NULL";
				$this->db->trans_begin();
				$this->load->model('Imagem_model', 'IMG');
				$insertImage = $this->IMG->insereImagem($dadosImg);

				if(!$insertImage && $this->db->trans_status() === FALSE){ //deu errado a imagem
					$resposta = ["msg" => "Erro ao inserir imagem no banco", "tipo" => "erro", "campo" => "foto"];
					$this->db->trans_rollback();
					rmdir($dirname);
					echo json_encode($resposta);
					return;
				}
				$imagem_id = $this->db->insert_id();
				$this->db->trans_commit();

				$this->load->model('Usuario_model', 'user');
				$resposta = $this->user->alteraImgUsuario($user_id, $imagem_id);
				if($resposta["tipo"] != "sucesso"){
					foreach(scandir($dirname) as $file) {
						if ('.' === $file || '..' === $file) continue;
						if (is_dir("$dirname/$file")) rmdir_recursive("$dirname/$file");
						else unlink("$dirname/$file");
					}
					rmdir($dirname);
					$resposta = ["msg" => $this->upload->display_errors(), "tipo" => "erro", "campo" => "fotos"];
					echo json_encode($resposta);
					return;
				}
			}
		}

		$this->session->set_userdata("user_email", $email);
		$this->session->set_userdata("user_name", $nome);
		$this->session->set_userdata("user_cidade", $cidade_id);
		$this->session->set_userdata("user_estado", $estado_id);

		echo json_encode($resposta);
		return;
	}

	public function visualizar($id = NULL){

		$dados["css"]  = "painel.css";
		$dados["js"]    = "item.js";

		$this->load->model('Usuario_model', 'user');
		$dados["usuario"] = $this->user->selecionaUsuario($id, TRUE);

		if($dados["usuario"]["nivel"]=="Instituição"){
			$this->load->model('Categoria_model', 'cat');
			$dados["categorias"] = $this->cat->buscaCategorias();

			$this->load->model('Instituicao_model', 'inst');
			$dados["categorias_interesse"] = $this->inst->buscaCategoriasInteresse($id);
		}

		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menu', $dados);
		$this->load->view('usuario', $dados);
		$this->load->view('templates/footer');
	}

	/**
	 * Será chamada por ajax para buscar as cidades
	 * @return json Da um echo em um JSON
	 */
	public function selecionaCidades(){
		$this->load->model("CidadeEstado_model", "CEM");

		$id_estado = $this->uri->segment(3, null);
		if(isset($id_estado) && !is_null($id_estado) && !empty($id_estado)){
			$cidades = $this->CEM->selecionaCidades((int) $id_estado);	

			if($cidades !== FALSE && !isset($cidades["tipo"])){
				echo json_encode(["cidades" => $cidades]);
				return;
			}
		}
		echo json_encode(["tipo" => "erro", "msg" => "Ocorreu um erro ao sistema, tente novamente mais tarde."]);
	}
}