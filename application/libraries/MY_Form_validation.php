<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Form Validation Extension
 */
class MY_Form_validation extends CI_Form_validation {

    /**
     *  MY_Form_validation::valid_url
     * @abstract Ensures a string is a valid URL
     */
    function valid_url($url) {
        if(preg_match("/^http(|s):\/{2}(.*)\.([a-z]){2,}(|\/)(.*)$/i", $url)) {
            if(filter_var($url, FILTER_VALIDATE_URL)) return TRUE;
        }
        $this->CI->form_validation->set_message('valid_url', 'The %s must be a valid URL.');
        return FALSE;
    }


    public function valid_fone($fone){     
        $this->CI->form_validation->set_message('valid_fone', 'O campo {field} não é um número válido.');   

        $fone = preg_replace('/[^0-9]/','',$fone);
        $fone = (string) $fone;

        if( strlen($fone) >= 10)
            return TRUE;
        else
            return FALSE;
    }

    public function valid_data_nascimento($data){
        $this->CI->form_validation->set_message('valid_data_nascimento', 'O campo {field} deve ter uma data menor que a atual.'); 
 
        $dateArray = explode("/", $data); // slice the date to get the day, month and year separately
      
        $d = 0;
        $m = 0;
        $y = 0;
        if (sizeof($dateArray) == 3) {
            if (is_numeric($dateArray[0]))
                $d = $dateArray[0];
            if (is_numeric($dateArray[1]))
                $m = $dateArray[1];
            if (is_numeric($dateArray[2]))
                $y = $dateArray[2];
        }

    
        if (checkdate($m, $d, $y)):
            //verifico se a data é menor que a atual
            $hoje = date('Y/m/d');
            $data = converter_data_para_internacional($data);
        
            $hoje = strtotime($hoje);
            $data = strtotime($data);       
            
            if ($data < $hoje):
                return True;
            else:
                return false;
            endif;
        else:
                return False;
        endif;
        return false;
    }

    public function escolheu_um_item($integer){   
        $this->CI->form_validation->set_message('escolheu_um_item', 'Escolha um item para o {field}');
        return false;
        //$integer = intval($integer);
        if ($integer != "0"){ //se o cpf for valido, verifico no banco
            return true;
        }
        else{
            
            $this->CI->form_validation->set_message('escolheu_um_item', 'Escolha um item para o {field}');
            return false;
        }
            
    }


    public function cpf_valido($str)
    {        
        if (CPFValido($str)){ //se o cpf for valido, verifico no banco
            return true;
        }
        else{
            
            $this->CI->form_validation->set_message('cpf_valido', 'O CPF informado não é válido');
            return false;
        }
            
    }

    public function cpf_cliente_ja_cadastrado($cpf,$codCliente){       
        
        $query = "Select count(*) as resultado from cliente where cpf=\"$cpf\" and cod_cliente!=$codCliente";
        $resposta = selectGenerico($query);
        if ($resposta[0]->resultado > 0){
            $this->CI->form_validation->set_message('cpf_cliente_ja_cadastrado', 'O CPF informado já está cadastrado');
            return false;
            
        }
        else{
            return true;
        }
    }
    
    //--------------------------------------------------------------------------------------------

    /**
     * MY_Form_validation::alpha_extra()
     * @abstract Alpha-numeric with periods, underscores, spaces and dashes
     */
    function alpha_extra($str) {
        $this->CI->form_validation->set_message('alpha_extra', 'The %s may only contain alpha-numeric characters, spaces, periods, underscores & dashes.');
        return ( ! preg_match("/^([\.\s-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
    }

    

    /**
     * MY_Form_validation::numeric_comma()
     * @abstract Numeric and commas characters
     */
    function numeric_comma($str) {
        $this->CI->form_validation->set_message('numeric_comma', 'The %s may only contain numeric & comma characters.');
        return ( ! preg_match("/^(\d+,)*\d+$/", $str)) ? FALSE : TRUE;
    }

    /**
     * MY_Form_validation::matches_pattern()
     * @abstract Ensures a string matches a basic pattern
     */
    function matches_pattern($str, $pattern) {
        if (preg_match('/^' . $pattern . '$/', $str)) return TRUE;
        $this->CI->form_validation->set_message('matches_pattern', 'The %s field does not match the required pattern.');
        return FALSE;
    }   

}