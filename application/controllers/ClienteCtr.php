<?php
defined('BASEPATH') or exit('No direct script access allowed');


class ClienteCtr extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo'); # add your city to set local time zone
        $this->load->model('ClienteMdl', 'cliente_model');
    }

    public function Index()
    {
        $dados['registros']     = selectGenerico('SELECT c.cod_cliente, c.nome_cliente FROM cliente c');
        $dados['tituloGuia']    = 'Registro de clientes';

        $this->load->view('Cliente/cadastroCliente', $dados);
    }

    public function editarCliente($cod_cliente){
        $dados                  = array();
        $dados['validacaoForm'] = "";
        $opSucesso = false;
        
        $dados              = $this->carregarCampos();

        $dadosCliente       = $this->carregarDadosCliente($cod_cliente);
        $dados['cliente']   = $dadosCliente['cliente'];        
        
        
        //retorna se possui algum campo que não passou na validacao
        if ($this->validaCampos() == false){
            $dados['validacaoForm'] = validation_errors();
            $dadosPost          = $this->input->post();//recebe os valores do post
            $celularesCliente   = $this->pegarCelularesCliente($dadosPost);
        }
        else{//passou na validacao
            $dadosPost          = $this->input->post();//recebe os valores do post
            $dadosProntos       = $this->corrigirCamposParaBanco($dadosPost);
            $celularesCliente   = $this->pegarCelularesCliente($dadosPost);

            $resposta  = $this->cliente_model->editarCliente($cod_cliente, $dadosProntos);   

            //se conseguiu editar, cadastra os celulares
            if ($resposta){            
                $opSucesso = $this->cliente_model->cadastrarCelularCliente($cod_cliente, $celularesCliente);
            }  
            if ($opSucesso)         
                redirect('Cliente','refresh');
        }    
        if ($celularesCliente == false){
            $celularesCliente = $dadosCliente['celular_cliente'];
        }

        $dados['celulares'] = $celularesCliente;
        $dados['tituloGuia']    = 'Alterar cliente';
        $this->load->view('Cliente/alterarCliente', $dados);
    }


    public function novoCliente(){
        //declaracao de variaveis
        $dados                  = array();
        $codClienteNovo         = 0;
        $dados['validacaoForm'] = "";
        $opSucesso = false;

        $dados = $this->carregarCampos(0); //select no banco para popular um combobox(select HTML)
        
        
        //retorna se possui algum campo que não passou na validacao
        if ($this->validaCampos() == false){
            $dados['validacaoForm'] = validation_errors();
            $dadosPost          = $this->input->post();//recebe os valores do post
            $celularesCliente   = $this->pegarCelularesCliente($dadosPost);
        }
        else{//passou na validacao
            $dadosPost          = $this->input->post();//recebe os valores do post
            $dadosProntos       = $this->corrigirCamposParaBanco($dadosPost);
            $celularesCliente   = $this->pegarCelularesCliente($dadosPost);


    
            $codClienteNovo     = $this->cliente_model->cadastrarCliente($dadosProntos);            
            //se conseguiu cadastrar, cadastra os celulares
            if ($codClienteNovo > 0){            
                $opSucesso = $this->cliente_model->cadastrarCelularCliente($codClienteNovo, $celularesCliente);
            }  
            if ($opSucesso)         
                redirect('Cliente','refresh');
        }        

        $dados['celulares'] = $celularesCliente;
        
        $dados['tituloGuia']    = 'Novo cliente';
        $this->load->view('Cliente/novoCliente', $dados);   
    }

    public function excluirCliente($cod_cliente)
    {
        if ($this->cliente_model->excluirCelulares($cod_cliente)){
            if ($this->cliente_model->excluirCliente($cod_cliente)) :
                redirect('Cliente', 'refresh');
            else :
                echo "erro";
            endif;
        }
    }

    private function pegarCelularesCliente($array){
        $arrayRetorno = array();
        foreach ($array as $campo => $valor) {             
            $pos = strripos($campo, 'm_celular_');
            if ($pos !== false) { //se achar algum celular..
                $num = substr($campo, 10);
                $num = (int)$num;

                $arrayRetorno[$num] = $valor;
                //echo "Encontrou: ".$campo ." => ".$valor."<br>";
            }             
        }
        return $arrayRetorno;
    }


    private function corrigirCamposParaBanco($array){
        foreach ($array as $campo => $valor) {
            if ((($campo == "cod_banco") ||
                ($campo == "cod_profissao") ||
                ($campo == "cod_orgao_classe") ||
                ($campo == "cod_tipo_conta") ||
                ($campo == "cod_estado_civil") ||
                ($campo == "cod_nacionalidade")) && ($valor == 0)) {
                $array[$campo] = 1;
            }

            //converte a data_nascimento para o padrao do banco
            if ($campo == "data_nascimento") {                
                $array[$campo] = converter_data_para_internacional($valor);
            }
            if ($campo == "descricao_cliente") {
                $array[$campo] = converterTagHTMLParaBanco($valor);
            }   
            
            
            //echo $campo." => ".$valor."<br>";
            $pos      = strripos($campo, 'm_celular_');            
            if ($pos !== false) { //se encontrar os celulares, remove
                unset($array[$campo]); //remove os celulares
            } 
        }

        //adiciona o campo data_criado no array
        $array['data_criado'] = date('Y-m-d H:i:s');

        //remove itens indesejados o do array que vai pro bd
        unset($array['enviar']);
        unset($array['files']);

        
        return $array;
    }


    private function validaCampos(){
        $cpf        = $this->input->post('cpf');
        $codCliente = $this->input->post('cod_cliente');          
        
        
        $this->form_validation->set_rules('cpf', 'cpf', 'cpf_valido');        
        if (CPFValido($cpf)){
            $this->form_validation->set_rules('cpf', 'cpf', "cpf_cliente_ja_cadastrado[$codCliente]");            
        }        

        $this->form_validation->set_rules('nome_cliente', 'nome do cliente', 'trim|required');
        $this->form_validation->set_rules('data_nascimento', 'data de nascimento', 'valid_date|valid_data_nascimento'); //caso digite a data, verifica se é valiad
        $this->form_validation->set_rules('email_cliente', 'e-mail', 'valid_email');    
        $this->form_validation->set_rules(' ',' ', "callback_cadastrouCelular|callback_valid_celular");
           

        if ($this->form_validation->run() == false){
            return false;
        }
        return true;
    }

    private function carregarDadosCliente($codCliente = 0){
        $celulares = array();

        if ($codCliente > 0){
            //pego as colunas da tabela cliente para este cliente
            $dadosCliente = $this->cliente_model->selectCliente($codCliente);
            $dados['cliente'] = $dadosCliente[0];

            //pego os telefones que tem o cod_cliente igual a este          
            $resposta = selectGenerico("SELECT c.cod_cliente_telefone, c.cod_cliente, c.telefone ".
                                       "FROM cliente_telefone c ".
                                        "WHERE c.cod_cliente = ".$codCliente);
            $qtde   = selectGenerico("SELECT count(*) as qtde ".
                                     "FROM cliente_telefone c ".
                                     "WHERE c.cod_cliente = ".$codCliente);
            $qtde  = $qtde[0]->qtde;
            

            if ($resposta){ //encontrou registros
                for ($x = 1; $x <= $qtde; $x++){
                    $celulares[$x] = $resposta[$x-1]->telefone;
                }    
            }
            $dados['celular_cliente'] = $celulares;
        }
        return $dados;
    }


    private function carregarCampos(){
        $nacionalidade    = array();
        $profissoes       = array();
        $banco            = array();
        $tipo_conta_banco = array();
        $estado_civil     = array();
        $orgao_classe     = array();       


        //nacionalidade
        //---------------------------------------------------------------------------------------------------
        $resposta = selectGenerico('SELECT n.cod_nacionalidade, n.nome_nacionalidade FROM nacionalidade n');
        $nacionalidade[0] = "";
        foreach ($resposta as $resp) :
            $nacionalidade[$resp->cod_nacionalidade] = $resp->nome_nacionalidade;
        endforeach;
        $dados['nacionalidade'] = $nacionalidade;
        //---------------------------------------------------------------------------------------------------

        //profissoes
        //---------------------------------------------------------------------------------------------------
        $resposta = selectGenerico('SELECT p.cod_profissao, p.nome_profissao FROM profissoes p');
        $profissoes[0] = "";
        foreach ($resposta as $resp) :
            $profissoes[$resp->cod_profissao] = $resp->nome_profissao;
        endforeach;
        $dados['profissoes'] = $profissoes;
        //---------------------------------------------------------------------------------------------------

        //banco
        //---------------------------------------------------------------------------------------------------
        $resposta = selectGenerico('SELECT b.cod_banco, b.nome_banco FROM banco b');
        $banco[0] = "";
        foreach ($resposta as $resp) :
            $banco[$resp->cod_banco] = $resp->nome_banco;
        endforeach;
        $dados['banco'] = $banco;
        //---------------------------------------------------------------------------------------------------

        //tipo_conta_banco
        //---------------------------------------------------------------------------------------------------
        $resposta = selectGenerico('SELECT t.cod_tipo_conta, t.nome_tipo_conta FROM tipo_conta_banco t');
        $tipo_conta_banco[0] = "";
        foreach ($resposta as $resp) :
            $tipo_conta_banco[$resp->cod_tipo_conta] = $resp->nome_tipo_conta;
        endforeach;
        $dados['tipo_conta_banco'] = $tipo_conta_banco;
        //--------------------------------------------------------------------------------------------------- 

        //estado_civil
        //--------------------------------------------------------------------------------------------------- 
        $resposta = selectGenerico('SELECT e.cod_estado_civil, e.nome_estado_civil FROM estado_civil e');
        $estado_civil[0] = "";
        foreach ($resposta as $resp) :
            $estado_civil[$resp->cod_estado_civil] = $resp->nome_estado_civil;
        endforeach;
        $dados['estado_civil'] = $estado_civil;
        //--------------------------------------------------------------------------------------------------- 

        //orgao_classe
        //--------------------------------------------------------------------------------------------------- 
        $resposta = selectGenerico('SELECT o.cod_orgao_classe, o.nome_orgao_classe FROM orgao_classe o');
        $orgao_classe[0] = "";
        foreach ($resposta as $resp) :
            $orgao_classe[$resp->cod_orgao_classe] = $resp->nome_orgao_classe;
        endforeach;
        $dados['orgao_classe'] = $orgao_classe;
        //---------------------------------------------------------------------------------------------------        

        return $dados;
    }

    //callback validation
    public function cadastrouCelular(){
        $this->form_validation->set_message('cadastrouCelular','Informe pelo menos um número para contato');
        
        $celularesCliente = $this->pegarCelularesCliente($this->input->post());
        if (sizeof($celularesCliente) > 0){  
            foreach($celularesCliente as $campo => $valor){
                if (($valor != "") or ($valor)){
                    return true;
                }
            }    
            return false;//se nao retornou true no meio do foreach é pq n cadastrou nada
        }
        else{
            return false;
        }
    }
    public function valid_celular(){
        $this->form_validation->set_message('valid_celular','Informe pelo menos um número válido');

        $celularesCliente = $this->pegarCelularesCliente($this->input->post());
        if (sizeof($celularesCliente) > 0){            
            //percorre os telefones inseridos
            foreach ($celularesCliente as $campo => $valor){
                if (strlen($valor) >= 14){ //se um dos telefones for valido, da ocmo true
                    return true;
                }
            }
            return false;
            //se apos percorrer o foreach e nao entrou no true; e pq os tel n é valido            
        }
        else{
            return false;
        }
    }
}
