<?php
class erro extends Controller{

	function __construct(){
		parent::__construct();		
	}

	function index(){
		$this->view->render("erro/index");
	}

}
?>