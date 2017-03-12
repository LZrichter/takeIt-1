<?php
/**
 * Class Config
 * All global configurations
 */
class Config{
	//Array of configs
	private $config = [
		"mainURL" 	=> "http://takeit.com.br/",
		"database" 	=> [
			"engine" 	=> "mysql",
			"host" 		=> "localhost",
			"user" 		=> "root",
			"database" 	=> "takeit",
			"password" 	=> ""
		],
		"folders" => [
			"librarys" 		=> "libs",
			"views" 		=> "views",
			"controllers" 	=> "controllers",
			"models" 		=> "models",
			"assets" 		=> "assets"
		],
		"pages" => [
			"acceptedPages" => [
				"inicio", "erro"
			],
			"mainPage" 	=> "inicio",
			"errorPage"	=> "erro"
		]
	];

	/**
	 * Function __get
	 * Returns a value if exists on the main $config array
	 * @param  string $value 		Value needed
	 * @return string/array/bool 	Returns the value if exists in the array $config, if not, return false
	 */
	function __get($value){
		if(isset($this->config[$value]))
			return $this->config[$value];
		else return false;
	}

} ?>