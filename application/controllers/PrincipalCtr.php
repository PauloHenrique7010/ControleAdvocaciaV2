<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PrincipalCtr extends CI_Controller {
    function __construct(){
        parent ::__construct();
    }

    public function Index(){
        //metodo padrão do controller
        $dados['tituloGuia'] = 'Controle Advocacia';                
        //Caso precise do IP SERVIDOR
        /*
        $host= gethostname();
        $ip = gethostbyname($host);
        echo $ip;*/
        
        $this->load->view('principal',$dados);
    }
    
    public function enviarEmail($destinatario, $assunto, $mensagem){
        $resposta = '';

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'ph.peugout406@gmail.com',
            'smtp_pass' => 'escoliose',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email',$config);        
        $this->email->set_newline("\r\n");


        $this->email->from('Controle Advocacia');
        $this->email->to($destinatario);
        $this->email->subject($assunto);
        $this->email->message($mensagem);

        if ($this->email->send()):
            $resposta = "enviado";
        else:
            $resposta = $this->email->print_debugger();
        endif;

        return $resposta;
    }
}
?>
