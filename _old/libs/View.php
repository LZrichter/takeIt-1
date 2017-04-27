<?php 
class View{

	function __construct(){
		$this->conf = new Config;
	}

	/**
	 * Function render
	 * Render a view
	 * @param  string $name File to be render as a view
	 * @return void
	 */
	function render($name){
		$this->viewFile = $this->conf->folders["views"]."/".$name.".php";

		// If is a ajax call, the header and footer are not included
		if(!isset($this->ajax) || $this->ajax !== true)
			require_once $this->conf->folders["views"]."/header.php";

		if(file_exists($this->viewFile))
			require_once $this->viewFile;
		
		if(!isset($this->ajax) || $this->ajax !== true)
			require_once $this->conf->folders["views"]."/footer.php";
	}

} ?>