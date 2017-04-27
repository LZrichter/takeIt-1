<?php 
	/**
	 * Class router
	 * Responsible for the routing of all pages
	 */
	class Router{

		/**
		 * Function __construct
		 * Initialize the class router
		 * @param  array $data Initial data provided by the $_REQUEST param
		 * @return void
		 */
		public function __construct(array $data){
			$this->conf = new Config;
			$this->data = $data;

			self::prepare();
		}

		/**
		 * Function go
		 * Main function, responsible for the inclusion of all classes
		 * @return void
		 */
		public function go(){
			if(self::ok()){
				$this->addFile($this->file);

				$p = new $this->page();
				if(isset($_POST["ajax"]) and $_POST["ajax"] == "1"){
					$p->ajax = true;
					$p->view->ajax = true;
				}else{
					$p->ajax = false;
					$p->view->ajax = false;
				}

				if(isset($this->method)){
					if(method_exists($p, $this->method))
						$p->{$this->method}();
					else{
						$p->FNF = true; //Function not Found
						$p->index();
					}
				}else $p->index();
			}else self::err();

			exit;
		}

		/**
		 * Function prepare
		 * Prepare the data, find missmatches
		 * @return void
		 */
		private function prepare(){
			if(is_array($this->data)){
				if(isset($this->data["url"])){
					if(strpos($this->data["url"], "/") !== false){
						$sep = explode("/", $this->data["url"]);
						$url = $sep[0]; // Sep -> Váriável separação

						array_shift($sep); //Removing the url from the content
					}else $url = $this->data["url"];

					if(self::pages($url)){
						$this->page = $url;

						if(isset($sep) and count($sep)>0){
							$_REQUEST["method"] = $this->method = $sep[0];
							$_REQUEST["page"]   = $this->page;

							array_shift($sep);

							if(count($sep)>0) 
								$_REQUEST["content"] = $sep;
						}
					}else $this->page = $this->conf->pages["errorPage"];
				}else $this->page = $this->conf->pages["mainPage"];
			}else $this->page = $this->conf->pages["mainPage"];

			return;
		}

		/**
		 * Function err
		 * Treat errors the occur
		 * @return void
		 */
		private function err(){
			header("Location: ".ROOT.$this->conf->pages["errorPage"]);
		}

		/**
		 * Function ok
		 * Informs if everything is ok to rout
		 * Only test controllers
		 * @return bool
		 */
		private function ok(){
			$this->file = $this->conf->folders["controllers"]."/".$this->page.".php";

			if($this->addFile($this->file)):
				if(class_exists($this->page))
					return true;
			endif;

			return false;
		}

		/**
		 * Function pages
		 * Test if page exists and if have permission
		 * @param  string page 	Name of the page required
		 * @return bool      	True if ok, false if not ok
		 */
		private function pages($page){
			//Array of all pages
			$allPages = $this->conf->pages["acceptedPages"]; 
			
			if(in_array($page, $allPages)) return true;
			return false;
		}

		/**
		 * Function addFile
		 * Responsible for testing if a file exists and require the file
		 * @param string $path 	Path to the file
		 * @return bool 		True if file exists, False if not
		 */
		private function addFile($path){
			$DOCROOT = $_SERVER["DOCUMENT_ROOT"];

			if(file_exists($DOCROOT."/".$path)){
				require_once $DOCROOT."/".$path;
				return true;
			}else return false;
		}

	} 
?>