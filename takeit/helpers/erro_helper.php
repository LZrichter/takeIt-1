<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

if(!class_exists('Erro')){
	class Erro{

		/**
		 * Tipos de erros encontrados no sistema
		 * @var [type]
		 */
		private $tipos = [
			"sql" => "Erro na execução do Banco de Dados",
			"pdo" => "Erro na conexão Banco de Dados",
			"sys" => "Erro no Sistema"
		];
		public $arrayErros = "";
		public $temErro = FALSE;

		function __construct(){ }

		/**
		 * Quando um novo erro é inserio com $this->erro(), essa função é chamada para tratar
		 * @param  string $errorTipo O tipo de erro
		 * @param  string $errorMsg  O Erro da mensagem
		 * @return void
		 */
		public function __invoke(string $erroTipo, string $erroMsg = ""){
			$this->temErro = TRUE;
			$this->arrayErros[$erroTipo][] = (empty($errorMsg) ? "Ocorreu um erro." : $erroMsg);
		}

		/**
		 * Chamado quando é dado echo no objeto da classe, então a primeira mensagem de erro será mostrada
		 * @return string Mensagem de erro
		 */
		public function __toString(){
			if(isset(self::$arrayErros) and !empty(self::$arrayErros))
				foreach(self::$arrayErros as $tipo => $msg) 
					return self::$tipos[$tipo] . " - " . $msg;
			else return "Nenhum erro encontrado";
		}

		/**
		 * Pegar a mensagem do erro sem ser com echo
		 * @return string Mensagem de erro
		 */
		public function erroMsg(){
			return self::__toString();
		}

		/**
		 * Retorna a quantidade de erros inseridos
		 * @return int Quantidade de erros
		 */
		public function numErros(){
			return (isset(self::$arrayErros) ? count(self::arrayErros) : 0);
		}

		/**
		 * Retorna todos os erros armazenados
		 * @return array Array com os erros
		 */
		public function todosErros(){
			return self::$arrayErros;
		}

	}

}
