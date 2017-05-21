<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Welcome_model extends CI_Model{

	function __construct(){
		parent::__construct();

		// $this->load->database();
	}

	public function teste(){
		return "dando certo";
	}

} ?>