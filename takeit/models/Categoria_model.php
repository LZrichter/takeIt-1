<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Categoria_model extends CI_Model {

        public function __construct() {
                parent::__construct();

                $this->load->database();
        }

		/**
		* Busca no Banco de Dados todas as categorias e as retorna
		* @return 				Array com os dados buscados das categorias ou mensagem de erro
		*	Array format:
		*		array(
		*			array(
		*				"categoria_id" => "",
		*				"categoria_nome" => ""
		*			),
		*			...
		*		)
		*	Ou:
		*		array(
		*			"Error" => ""
		*		)
		*/
        public function buscaCategorias(){

			try{

				$sql = "SELECT categoria_id, categoria_nome	FROM categoria";

				if(!$query = $this->db->query($sql)){
					if($this->db->error()){
						return array("Error" => "$error[message]");
					}
				} else if (empty($query->result())) {
					return array("Error" => "No data found");
				} else {
					$count = 0;
					foreach($query->result() as $row){
						foreach ($row as $campo => $valor) {
							$result[$count][$campo] = $valor;
						}
						$count++;
					}
					return $result;
				}
				
			} catch(Exception $E) {
				return array("Error" => "Server was unable to execute query");
			}
        }

}