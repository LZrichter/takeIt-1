<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

if(!class_exists('Bcrypt')){
	class Bcrypt {
		
		protected static $_saltPrefix = '2a';
		protected static $_defaultCost = 10;
		protected static $_saltLength = 22;

		public function hash($string, $cost = null){
			if (empty($cost)) {
				$cost = self::$_defaultCost;
			}

			// Salt
			$salt = self::generateRandomSalt();

			// Hash string
			$hashString = self::__generateHashString((int)$cost, $salt);

			return crypt($string, $hashString);
		}

		public function check($string, $hash){
			return (crypt($string, $hash) === $hash);
		}

		public function generateRandomSalt(){
			// Salt seed
			$seed = uniqid(mt_rand(), true);

			// Generate salt
			$salt = base64_encode($seed);
			$salt = str_replace('+', '.', $salt);

			return substr($salt, 0, self::$_saltLength);
		}

		private function __generateHashString($cost, $salt){
			return sprintf('$%s$%02d$%s$', self::$_saltPrefix, $cost, $salt);
		}

	}
}