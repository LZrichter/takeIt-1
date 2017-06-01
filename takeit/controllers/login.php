<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Login extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('login');

		if(testaLogin(true) && $this->uri->segment(2) != "sair") 
			redirect(base_url() . "doacoes", "refresh");
	}

	public function index(){		
		$dados["css"]    = "welcome.css";
		$dados["js"]	 = "welcome.js";
		$dados["js2"]	 = "login.js";

		//$this->load->model("usuario_model","user");
		$this->load->view('templates/head', $dados);
		$this->load->view('templates/menuWelcome');
		$this->load->view('login', $dados);
		$this->load->view('templates/footer');
	}

	public function entrar(){
		$data = $this->input->post();

		if(!isset($data["email"]) || empty(trim($data["email"]))){
			echo json_encode(["tipo" => "erro", "msg" => "E-mail não preenchido."]);
			return;
		}else if(!isset($data["password"]) || empty(trim($data["password"]))){
			echo json_encode(["tipo" => "erro", "msg" => "Senha não preenchida."]);
			return;
		}else{
			$this->load->model("Usuario_model","user");

			if($this->user->buscaUsuario(["email" => $this->input->post()["email"]])){
				if($this->user->ativo == "1"){
					if($this->user->testaSenha($data["password"])){
						$this->session->set_userdata("logged", TRUE);
						$this->session->set_userdata("user_id", $this->user->getId());
						$this->session->set_userdata("user_email", $this->user->email);
						$this->session->set_userdata("user_name", $this->user->nome);

						echo json_encode(["tipo" => "ok"]);
						return;
					}
				}else{
					echo json_encode(["tipo" => "erro", "msg" => "Essa conta foi desativada!"]);

					return;
				}
			}

			echo json_encode(["tipo" => "erro", "msg" => "E-mail ou senha incorretos!"]);
		}
	}

	public function sair(){
		$this->session->sess_destroy();

		redirect(base_url());
	}
}
