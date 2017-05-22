<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

class Instituicao_model extends CI_Model {

        public function __construct() {
                parent::__construct();

                $this->load->database();
        }

		/**
		* Busca no Banco de Dados N instituições a partir de um index e as retorna
		* @param  $dados 	Array com os dados necessários para a realização da consulta
		*	Array format:
		*		array(
		*			"quantidadePorPagina" => "",
		*			"paginaAtual" => "",
		*			"filtroUF" => "",
		*			"filtroMunicipio" => "",
		*			"filtroCategoria" => "",
		*			"filtroBusca" => ""
		*		)
		* @return 			Array com os dados buscados das instituições ou mensagem de erro
		*	Array format:
		*		array(
		*			array(
		*				"usuario_id" => "",
		*				"usuario_nome" => "",
		*				"cidade_nome" => "",
		*				"estado_uf" => ""
		*			),
		*			...
		*		)
		*	Ou:
		*		array(
		*			"Error" => ""
		*		)
		*/

        public function buscaInstituicoes($dados){
        	if(!isset($dados['quantidadePorPagina']) || !isset($dados['paginaAtual']) || !isset($dados['filtroUF']) || 
        		!isset($dados['filtroMunicipio']) || !isset($dados['filtroCategoria']) || !isset($dados['filtroBusca'])){
				return array("Error" => "Insuficient information to execute the query");
			}
			try{

				$sql = "SELECT usuario_id, usuario_nome, cidade_nome, estado_uf
				FROM estado e NATURAL JOIN cidade c NATURAL JOIN usuario u 
				NATURAL JOIN instituicao_categoria ic NATURAL JOIN categoria ct
				WHERE estado_uf = '".$dados['filtroUF']."' AND cidade_nome = '".$dados['filtroMunicipio']."' AND
				categoria_nome = '".$dados['filtroCategoria']."' AND usuario_nome LIKE '%".$dados['filtroBusca']."%' 
				LIMIT ".($dados['quantidadePorPagina']*($dados['paginaAtual']-1)).", ".$dados['quantidadePorPagina'];

				if(!$query = $this->db->query($sql)){
					if($this->db->error()){
						return array("Error" => "$error[message]");
					}
				} else {

					foreach($query->result() as $line){
						foreach ($line as $campo => $valor) {
							$result[count($line)-1][$campo] = $valor;
						}
					}
					return $result;
				}
				
			} catch(Exception $E) {
				return array("Error" => "Server was unable to execute query");
			}
        }

}