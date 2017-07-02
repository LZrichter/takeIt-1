<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

if(!function_exists("arrumaString")){
	/**
	 * Arruma uma string, removendo todos os caracteres especiais e espaços, colocando '-' no lugar
	 * @param  string $string    String a ser modificada
	 * @param  string $separator Separador a ser usado para a string modificada, padrao '-'
	 * @return string            String modificada
	 */
	function arrumaString($string, $separator = '-'){
	    $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
	    $special_cases = array( '&' => 'and', "'" => '');
	    $string = mb_strtolower(trim($string), 'UTF-8');
	    $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
	    $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
	    $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
	    $string = preg_replace("/[$separator]+/u", "$separator", $string);

	    return $string;
	}
}