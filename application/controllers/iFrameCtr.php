<?php
defined('BASEPATH') or exit('No direct script access allowed');


class iFrameCtr extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo'); # add your city to set local time zone
        
    }

    public function Index(){
        $dados = array();
        $this->load->view('iFrame', $dados);
    }

    public function competencia(){
        $pesquisa = $this->input->post('pesquisa');
        $sql = "SELECT f.cod_foro, f.nome_foro FROM foros f ";
        if ($pesquisa != ""){
            $sql.="WHERE nome_foro like '%".$pesquisa."%'";
        }
        $foros = selectGenerico($sql);
        
        
        /*echo var_dump($pesquisa);

        $sql = "SELECT f.cod_foro, f.nome_foro FROM foros f ";
        if ($pesquisa != ""){
            $sql.="WHERE nome_foro like '%".$pesquisa."%'";
        }
        $foros = selectGenerico($sql);
        $dados['registros'] = $foros;
        $dados['nomeObj1'] = 'cod_foro';
        $dados['nomeObj2'] = 'nome_foro';

        $this->load->view('iFrame', $dados);*/

        header('Content-Type: application/json');
        $json = array('type' => 'success',
                        'message' => $foros);

        echo json_encode($json);
    }    
}
