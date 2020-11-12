<?php
defined('BASEPATH') or exit('No direct script access allowed');
//1004281-77.2017.8.26.0101

class ProcessoCtr extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo'); # add your city to set local time zone
        $this->load->model('ProcessoMdl', 'processo_model');
    }

    public function Index(){
        $dados['registros']     = selectGenerico('SELECT p.cod_processo, p.assunto_principal From processo p');
        $dados['tituloGuia']    = 'Registro de processo';
        $this->load->view('Processo/cadastroProcesso', $dados);
    }

    public function novoProcesso(){
        $dados = $this->carregarCampos();

        if ($this->validaCampos() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosForm = $this->input->post();
            $dadosForm = $this->corrigirCamposBD($dadosForm);
            echo var_dump($dadosForm);

            $codAdvogadoNovo     = $this->processo_model->cadastrarProcesso($dadosForm);            
            if ($codAdvogadoNovo > 0){            
                redirect('Processo','refresh');
            }        
                
        }

        

        $dados['tituloGuia']    = 'Novo processo';
        $this->load->view('Processo/novoProcesso', $dados);
    }

    public function excluirProcesso($codProcesso){
        if ($this->processo_model->excluirProcesso($codProcesso))
            redirect('Processo', 'refresh');           
    }


    private function corrigirCamposBD($array){
        foreach ($array as $campo => $valor) {
            if (($campo == "data_distribuicao") && ($array[$campo] != "")) {                
                $array[$campo] = converter_data_para_internacional($valor);
            break;
            }

            /*if ($campo == 'dependencia'){
                $array[$campo] = true;
            }*/

        }
        //adiciona o campo data_criado no array
        $array['data_criado'] = date('Y-m-d H:i:s');

        //remove itens indesejados o do array que vai pro bd
        unset($array['enviar']);
        unset($array['advogados']);
        unset($array['foro']);
        unset($array['competencia']);

        
        return $array;
    }

    private function validaCampos(){
        $this->form_validation->set_rules('grau_peticionamento', 'grau do peticionamento', 'required');
        $this->form_validation->set_rules('tipo_acao', 'tipo da ação', 'required');
        $this->form_validation->set_rules('assunto_principal', 'assunto principal', 'required');
        $this->form_validation->set_rules('cod_foro', 'foro', 'required');
        $this->form_validation->set_rules('cod_competencia', 'competência', 'required');
     

        if ($this->form_validation->run() == false){
            return false;
        }
        return true;
    }



    private function carregarCampos(){
        $grauPeticionamento = array(
            ''  => '',
            '1' => 'Peticionamento Eletrônico de 1º Grau',
            '2' => 'Peticionamento Eletrônico de 2º Grau',
            '3' => 'Peticionamento Eletrônico do Colégio Recursal'
        );
        $dados['grauPeticionamento'] = $grauPeticionamento;


        $peticionamento1Grau = array(
            '0'  => '',
            '1' => 'Petição Inicial de 1° Grau',
            '2' => 'Petição Intermediária de 1° Grau',
            '3' => 'Petição Intermediária de 1º Grau para Requisitórios'
        );
        $dados['peticionamento1Grau'] = $peticionamento1Grau;

        $peticionamento2Grau = array(
            ''  => '',
            '1' => 'Peticionamento Inicial de 2º Grau',
            '2' => 'Peticionamento Intermediário de 2º Grau'
        );
        $dados['peticionamento2Grau'] = $peticionamento2Grau;

        $peticionamentoColegioRecursao = array(
            ''  => '',
            '1' => 'Peticionamento Inicial - Colégio Recursal ',
            '2' => 'Peticionamento Intermediário - Colégio Recursal'
        );
        $dados['peticionamentoColegioRecursao'] = $peticionamentoColegioRecursao;

        $competencia = array(
            '' => '',
            '1' => 'Cível',
            '2' => 'Família e Sucessões',
            '3' => 'Infância e Juventude Cível',
            '4' => 'Juizado Especial Cível',
            '5' => 'Criminal',
            '6' => 'Juizado Especial Criminal',
            '7' => 'Juizado Criminal - Violência Doméstica',
            '8' => 'Juizado da Violência Doméstica-Família'
        );
        $dados['competencia'] = $competencia;

        $dados['tipoAcao'] = array(
            '' => '',
            '1' => 'Trabalhista',
            '2' => 'Federal',
            '3' => 'Estadual'
        );


        return $dados;
    }
}
