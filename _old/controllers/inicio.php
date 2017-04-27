<?php 
class inicio extends Controller{

	function __construct(){
		parent::__construct();
	}

	/**
	 * Function index
	 * Main function for every control class
	 * @return void 
	 */
	public function index(){
		$this->view->render("inicio/index");

		// require "models/inicioModel.php";
		// $model = new inicioModel();
	}

	public function teste(){
		$this->view->teste = "penis";	
		$this->view->render("inicio/teste");
	}

} ?>