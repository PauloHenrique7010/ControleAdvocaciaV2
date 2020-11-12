<?php
defined('BASEPATH') or exit('No direct script access allowed');


class PesquisaCtr extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo'); # add your city to set local time zone
        
    }

    public function Index(){
        
    }

    public function foro(){
        $pesquisa = $this->input->post('pesquisa');
        $sql = "SELECT f.cod_foro, f.nome_foro FROM foros f ";
        if ($pesquisa != ""){
            $sql.="WHERE nome_foro like '%".$pesquisa."%'";
        }
        $foros = selectGenerico($sql);
        

        header('Content-Type: application/json');
        $json = array('type' => 'success',
                        'registros' => $foros);

        echo json_encode($json);
    }  

    public function competencia(){
        $pesquisa = $this->input->post('pesquisa');
        $codForo = $this->input->post('cod_foro');

        $sql =  "SELECT c.cod_competencia, c.nome_competencia ".
                "FROM relacao_foros_competencias r ".
                "LEFT JOIN competencias c ON r.cod_competencia = c.cod_competencia ".
                "WHERE r.cod_foro = $codForo ";
        if ($pesquisa != ""){
            $sql.="AND c.nome_competencia like '%".$pesquisa."%'";
        }
        $foros = selectGenerico($sql);        

        header('Content-Type: application/json');
        $json = array('type' => 'success',
                        'registros' => $foros);

        echo json_encode($json);
    } 

    public function advogado(){
        $pesquisa = $this->input->post('pesquisa');
        $sql = "SELECT a.cod_advogado, a.nome_advogado FROM advogado a ";
        if ($pesquisa != ""){
            $sql.="WHERE a.nome_advogado like '%".$pesquisa."%'";
        }
        $advogados = selectGenerico($sql);
        

        header('Content-Type: application/json');
        $json = array('type' => 'success',
                        'registros' => $advogados);

        echo json_encode($json);
    } 

    public function tokenEscavador(){
        $sql = "SELECT t.access_token, t.refresh_token FROM token_escavador t";        
        $registros = selectGenerico($sql);
    

        header('Content-Type: application/json');
        $json = array('type' => 'success',
                        'registros' => $registros);

        echo json_encode($json);
    } 

    public function cliente(){
        $pesquisa = $this->input->get('pesquisa');
        $sql = "SELECT c.cod_cliente, c.nome_cliente, c.cpf from cliente c ";
        if ($pesquisa != ""){
            $sql.="WHERE c.nome_cliente like '%".$pesquisa."%'";
        }
        $registros = selectGenerico($sql);
        

        header('Content-Type: application/json');
        $json = array('type' => 'success',
                        'registros' => $registros);

        echo json_encode($json);
    }

    public function formaPagamento(){
        $sql = "SELECT f.cod_forma_pagamento, f.nome_forma_pagamento FROM forma_pagamento f ";
        
        $registros = selectGenerico($sql);
        

        header('Content-Type: application/json');
        $json = array('type' => 'success',
                        'registros' => $registros);

        echo json_encode($json);
    } 
    
    

}
