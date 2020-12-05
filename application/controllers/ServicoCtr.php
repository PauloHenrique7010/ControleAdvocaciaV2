<?php
defined('BASEPATH') or exit('No direct script access allowed');


class ServicoCtr extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo'); # add your city to set local time zone
        $this->load->model('ServicoMdl', 'servico_model');
        $this->load->model('FuncoesMdl', 'funcoes_model');
    }

    public function Index()
    {
        $dados = [];
        $this->load->view('Servico/cadastroServico', $dados);
    }

    public function novoServico()
    {
        unset($arrayCobaia);
        $registros = buscarTodosRegistrosTabela('tipo_servico');
        $arrayCobaia[0] = "";
        foreach ($registros as $key => $value) {
            $arrayCobaia[$value->cod_tipo_servico] = $value->nome_tipo_servico;
        }
        $dados['tipoServico'] = $arrayCobaia;        

        unset($arrayCobaia);
        $registros = buscarTodosRegistrosTabela('tipo_processo');
        $arrayCobaia[0] = "";
        foreach ($registros as $key => $value) {
            $arrayCobaia[$value->cod_tipo_processo] = $value->nome_tipo_processo;
        }
        $dados['tipoProcesso'] = $arrayCobaia;        

        unset($arrayCobaia);
        $registros = buscarTodosRegistrosTabela('tipo_acao');
        $arrayCobaia[0] = "";
        foreach ($registros as $key => $value) {
            $arrayCobaia[$value->cod_tipo_acao] = $value->nome_tipo_acao;
        }
        $dados['tipoAcao'] = $arrayCobaia;

        unset($arrayCobaia);
        $registros = buscarTodosRegistrosTabela('forma_pagamento');
        $arrayCobaia[0] = "";
        foreach ($registros as $key => $value) {
            $arrayCobaia[$value->cod_forma_pagamento] = $value->nome_forma_pagamento;
        }
        $dados['formasPagamento'] = $arrayCobaia;


        $dados['tituloGuia'] = 'Novo Serviço';
        $this->load->view('Servico/novoServico', $dados);
    }

    public function confirmarNovoServico()
    {
        //https://stackoverflow.com/questions/10955017/sending-json-to-php-using-ajax
        /*answered Nov 23 '18 at 12:02
        Tadej
        4,68144 gold badges3939 silver badges50*/


        $json = ($this->input->post('MyData'));
        $phpObject = json_decode($json);

        $servico = array(
            "valor_servico" => floatval ($phpObject->valorServico),
            "valor_entrada" => floatval ($phpObject->valorEntrada),            
            "cod_tipo_servico" => $phpObject->tipoServico,
            "cod_tipo_processo" => $phpObject->tipoProcesso,
            "cod_tipo_acao" => $phpObject->tipoAcao,
            "data_criado" => date('Y-m-d H:i:s')
        );

        $prestacoesCartao = $phpObject->prestacoesCartao;
        
        $partesServico = $phpObject->partesServico;


        try{
            if ($this->servico_model->cadastrarServico($servico, $prestacoesCartao, $partesServico)){
                $json = array('type' => 'success',
                        'registros' => "cadastrado");
                echo json_encode($json);
                redirect('','refresh');
            } 

        }
        catch (Exception $e) {
             //catch the exception thrown in do_something()
         //additional handling here
        }
    }

    public function pesquisar(){
        $filtros = ($this->input->get('pesquisa'));
        $registros =$this->servico_model->pesquisarServico($filtros);

        $newJsonString = json_encode($registros);
        header('Content-Type: application/json');
        echo $newJsonString;
    }

}
