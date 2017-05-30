<?php defined('BASEPATH') OR exit('OPSSS... Não é permitido direto acesso ao script!!');

if(!function_exists('validaCPF')){
    function validaCPF($cpf = null){
        if(empty($cpf)) return false;
     
        // Elimina possiveis mascaras
        $cpf = preg_replace("/[^0-9]/", '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
         
        // Verifica se o numero de digitos informados é igual a 11 
        if(strlen($cpf) != 11)
            return false;

        // Verifica se nenhuma das sequências invalidas abaixo foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
            return false;
         else{  
            // Calcula os digitos verificadores para verificar se o CPF é válido
            for($t = 9; $t < 11; $t++){
                for($d = 0, $c = 0; $c < $t; $c++){
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;
                if($cpf{$c} != $d)
                    return false;
            }
     
            return true;
        }
    }
}

if(!function_exists('validaCNPJ')){
    function validaCNPJ($cnpj){
        if(empty($cnpj)) return false;

        // Elimina possiveis mascaras
        $cnpj = preg_replace("/[^0-9]/", '', $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 18
        if(strlen($cnpj) != 14) return false; 

        // Cálculo do primeiro digito que é verificado com o caracter 17 da string
        $soma1 = ($cnpj[0] * 5) + ($cnpj[1] * 4) + ($cnpj[2] * 3) + ($cnpj[3] * 2) + ($cnpj[4] * 9) + ($cnpj[5] * 8) + ($cnpj[6] * 7) + ($cnpj[7] * 6) + ($cnpj[8] * 5) + ($cnpj[9] * 4) + ($cnpj[10] * 3) + ($cnpj[11] * 2); 

        $resto = $soma1 % 11; 
        $digito1 = $resto < 2 ? 0 : 11 - $resto; 

        // Cálculo do segundo digito que é verificado com o caracter 18 da string
        $soma2 = ($cnpj[0] * 6) + ($cnpj[1] * 5) + ($cnpj[2] * 4) + ($cnpj[3] * 3) + ($cnpj[4] * 2) + ($cnpj[5] * 9) + ($cnpj[6] * 8) + ($cnpj[7] * 7) + ($cnpj[8] * 6) + ($cnpj[9] * 5) + ($cnpj[10] * 4) + ($cnpj[11] * 3) + ($cnpj[12] * 2); 

        $resto = $soma2 % 11; 
        $digito2 = $resto < 2 ? 0 : 11 - $resto; 

        return (($cnpj[12] == $digito1) && ($cnpj[13] == $digito2));
    }
}