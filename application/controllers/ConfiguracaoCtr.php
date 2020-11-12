<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfiguracaoCtr extends CI_Controller {
    function __construct(){
        parent ::__construct();
        $this->load->model('ConfiguracaoMdl','configuracao_model');
        
    }

    public function Index(){       
        //$this->load->view('Administrador/principal');   
    }

    public function ConfiguracaoToken(){
        $dados['registro'] = $this->configuracao_model->selectConfiguracaoToken();               
        $dados['tituloGuia'] = 'Configuração Token';        
        $this->load->view('Administrador/configuracaoEscavador',$dados);   
    }

    public function ConfirmarConfiguracaoToken(){
        $dadosPost      = $this->input->post();//recebe os valores do post
        unset($dadosPost['enviar']); //remove o botao

            
        $sucesso        = $this->configuracao_model->confirmarConfiguracaoTokenEscavadorAPI($dadosPost);
            
        if ($sucesso > 0){
            redirect('AdminCtr/','refresh');
        }

    }
}
?>
