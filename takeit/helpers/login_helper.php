<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

if(!function_exists("testeLogin")){
	/**
	 * Testa se o usuário já está logado ou não e redireciona para a página de login caso não
	 * @param  boolean $retorna TRUE se deseja que o resultado seja retornado e a página não redirecionada
	 * @return boolean/void     Caso $retorna for true, será retornado TRUE se o usuário já esteja logado ou false se não, 
	 *         se $retorna for false, a página será redirecionada ou será dado echo em uma mensagem de erro caso for ajax
	 */
	function testaLogin($retorna = FALSE){
		$ci = & get_instance(); // Pega a instância do objeto sendo usado no momento no CodeIgniter

		$data = $ci->input->post();

		if(!$ci->session->has_userdata("logged") || $ci->session->userdata("logged") != TRUE){
			helperTestaLoginRedirect($retorna, $ci, $data);			
		}else{
			$ci->load->model("Usuario_model", "user");

			if($ci->user->selecionaUsuario((int) $ci->session->userdata("user_id"))){
				if($ci->user->ativo == "1") return true;
				else{
					$ci->session->sess_destroy();

					helperTestaLoginRedirect($retorna, $ci, $data);
				}
			}
		} 
	}

	function helperTestaLoginRedirect($retorna, $ci, $data){
		if($retorna) return false;
		if($ci->uri->segment(1) == "login") return;

		if(isset($data["ajax"])){
			echo json_encode(["tipo" => "erro", "msg" => "É necessário estar logado para executar essa operação!"]); 

			exit;
		}else{
			$ci->load->helper('url');
			redirect(base_url() . "login", "refresh"); 

			exit;
		}
	}
}