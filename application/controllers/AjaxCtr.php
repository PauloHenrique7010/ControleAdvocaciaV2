<?php
defined('BASEPATH') or exit('No direct script access allowed');


class AjaxCtr extends CI_Controller{

    function __construct(){
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo'); # add your city to set local time zone
        $this->load->model('AjaxMdl','ajax_model');
    }

    public function Index(){
    }

    public function aForo(){
        
        $this->form_validation->set_rules('nome_foro', 'Nome do foro', 'required');
        if($this->form_validation->run()){
            $this->ajax_model->CadastrarForo();       
        }
        else{
            $json = array(
                'type' => 'error',
                'message' => validation_errors()
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
    /*public function eForo(){
        $this->ajax_model->ExcluirForo();
    }*/

    public function eProfissao(){
        $codProfissao = $this->input->post('cod_profissao');

        if ($codProfissao > 0){
            $this->ajax_model->ExcluirProfissao($codProfissao);
        }
        else{
            $json = array(
                'type' => 'error',
                'message' => 'Profissão não encontrada'()
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }        
    }

    public function eOrgaoClasse(){
        $codOrgaoClasse = $this->input->post('cod_orgao_classe');

        if ($codOrgaoClasse > 0){
            $this->ajax_model->ExcluirOrgaoClasse($codOrgaoClasse);
        }
        else{
            $json = array(
                'type' => 'error',
                'message' => 'Orgão de classe não encontrado'
            );
            header('Content-Type: application/json');
            echo json_encode($json);
        }
    }

    public function eEstadoCivil(){
       $codEstadoCivil = $this->input->post('cod_estado_civil');
       $json = array();
       

        if ($codEstadoCivil > 0){            
            $json = $this->ajax_model->ExcluirEstadoCivil($codEstadoCivil);
        }
        else{
            $json = array(
                'type' => 'error',
                'title' => 'Erro!',
                'message' => 'Ocorreu um erro inesperado, contate o administrador!'
            );
            
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function eAdvogado(){
        $codAdvogado = $this->input->post('cod_advogado');
        $json = array();
        
 
         if ($codAdvogado > 0){            
             $json = $this->ajax_model->ExcluirAdvogado($codAdvogado);
         }
         else{
             $json = array(
                 'type' => 'error',
                 'title' => 'Erro!',
                 'message' => 'Ocorreu um erro inesperado, contate o administrador!'
             );
             
         }
         header('Content-Type: application/json');
         echo json_encode($json);
    }

    public function eForo(){
        $codigo = $this->input->post('codigo');
        $json = array();
        
 
         if ($codigo > 0){            
             $json = $this->ajax_model->ExcluirForo($codigo);
         }
         else{
             $json = array(
                 'type' => 'error',
                 'title' => 'Erro!',
                 'message' => 'Ocorreu um erro inesperado, contate o administrador!'
             );
             
         }
         header('Content-Type: application/json');
         echo json_encode($json);
    }
}
