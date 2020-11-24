<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminCtr extends CI_Controller {
    function __construct(){
        parent ::__construct();
        $this->load->model('BancoMdl','banco_model');
        $this->load->model('ProfissaoMdl','profissao_model');
        $this->load->model('OrgaoClasseMdl','orgao_classe_model');
        $this->load->model('EstadoCivilMdl','estado_civil_model');
        $this->load->model('AdvogadoMdl','advogado_model');
        $this->load->model('ForoMdl','foro_model');
    }

    public function Index(){       
        $this->load->view('Administrador/principal');   
    }

    public function Banco(){
        $dados['registros'] = $this->banco_model->selectBanco();

        $this->load->view('Administrador/cadastroBanco',$dados);   
    }

    public function NovoBanco(){
        $this->banco_model->CadastrarBanco();
    } 
    
    public function ExcluirBanco(){
        $this->banco_model->ExcluirBanco();
    } 

    public function AlterarBanco(){
        $this->banco_model->alterarBanco();
    } 

    public function Profissao(){
        $dados['tituloGuia'] = 'Cadastro profissão';
        $dados['registros'] = $this->profissao_model->selectProfissao();
        $this->load->view('Administrador/cadastroProfissao',$dados);
    }

    public function NovaProfissao(){
        if ($this->validaCamposProfissao() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            $sucesso        = $this->profissao_model->cadastrarProfissao($dadosPost);

            if ($sucesso > 0){
                redirect('Admin/Profissao','refresh');
            }
        }

        $dados['tituloGuia'] = 'Cadastrar profissão';
        $this->load->view('Administrador/novoProfissao',$dados);        
    }

    private function validaCamposProfissao(){      
        $this->form_validation->set_rules('nome_profissao', 'Profissão', 'trim|required');
           

        if ($this->form_validation->run() == false){
            return false;
        }
        return true;
    }

    public function AlterarProfissao($codProfissao){        
        $registros = $this->profissao_model->selectProfissao($codProfissao);
        $dados['registros'] = $registros[0];

        if ($this->validaCamposProfissao() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            
            
            $sucesso        = $this->profissao_model->alterarProfissao($dadosPost);

            if ($sucesso){
                redirect('Admin/Profissao','refresh');
            }
        }
        
        $dados['tituloGuia'] = 'Alterar profissão';
        $this->load->view('Administrador/AlterarProfissao',$dados);           
    }

    public function ExcluirProfissao($codProfissao){
        
        if (msgSucesso('Excluido!','Registro excluido com sucesso')):
            redirect('Admin/Profissao', 'refresh');
        endif;
    }

    public function OrgaoClasse(){
        $dados['tituloGuia'] = 'Cadastro orgão classe';
        $dados['registros'] = $this->orgao_classe_model->selectOrgaoClasse();
        $this->load->view('Administrador/cadastroOrgaoClasse',$dados);
    }

    public function NovoOrgaoClasse(){
        if ($this->validaCamposOrgaoClasse() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            $sucesso        = $this->orgao_classe_model->cadastrarOrgaoClasse($dadosPost);

            if ($sucesso > 0){
                redirect('Admin/OrgaoClasse','refresh');
            }
        }

        $dados['tituloGuia'] = 'Novo orgão classe';
        $this->load->view('Administrador/novoOrgaoClasse',$dados);
    }

    public function AlterarOrgaoClasse($codOrgaoClasse){
        $registros = $this->orgao_classe_model->selectOrgaoClasse($codOrgaoClasse);
        $dados['registros'] = $registros[0];

        if ($this->validaCamposOrgaoClasse() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            
            
            $sucesso        = $this->orgao_classe_model->alterarOrgaoClasse($dadosPost);

            if ($sucesso){
                redirect('Admin/OrgaoClasse','refresh');
            }
        }
        
        $dados['tituloGuia'] = 'Alterar orgão classe';
        $this->load->view('Administrador/alterarOrgaoClasse',$dados); 
    }   

    private function validaCamposOrgaoClasse(){
        $this->form_validation->set_rules('nome_orgao_classe', 'Nome orgão de classe', 'trim|required');
           

        if ($this->form_validation->run() == false){
            return false;
        }
        return true;

    }

    public function estadoCivil(){
        $dados['tituloGuia'] = 'Cadastro estado civil';
        $dados['registros'] = $this->estado_civil_model->selectEstadoCivil();
        $this->load->view('Administrador/cadastroEstadoCivil',$dados);
    }

    public function novoEstadoCivil(){
        if ($this->validaCamposEstadoCivil() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            $sucesso        = $this->estado_civil_model->cadastrarEstadoCivil($dadosPost);

            if ($sucesso > 0){
                redirect('Admin/EstadoCivil','refresh');
            }
        }

        $dados['tituloGuia'] = 'Novo estado civil';
        $this->load->view('Administrador/novoEstadoCivil',$dados);
    }

    public function AlterarEstadoCivil($codEstadoCivil){
        $registros = $this->estado_civil_model->selectEstadoCivil($codEstadoCivil);
        $dados['registros'] = $registros[0];

        if ($this->validaCamposEstadoCivil() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            
            
            $sucesso        = $this->estado_civil_model->alterarEstadoCivil($dadosPost);

            if ($sucesso){
                redirect('Admin/EstadoCivil','refresh');
            }
        }
        
        $dados['tituloGuia'] = 'Alterar estado civil';
        $this->load->view('Administrador/alterarEstadoCivil',$dados); 
    } 

    private function validaCamposEstadoCivil(){      
        $this->form_validation->set_rules('nome_estado_civil', 'Estado civil', 'trim|required');
           

        if ($this->form_validation->run() == false){
            return false;
        }
        return true;
    }

    public function Advogado(){
        $dados['tituloGuia'] = 'Cadastro advogados';
        $dados['registros'] = $this->advogado_model->selectAdvogado();
        $this->load->view('Administrador/cadastroAdvogado',$dados);
    }

    public function novoAdvogado(){
        if ($this->validaCamposAdvogado() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            $sucesso        = $this->advogado_model->cadastrarAdvogado($dadosPost);

            if ($sucesso > 0){
                redirect('Admin/Advogado','refresh');
            }
        }

        $dados['tituloGuia'] = 'Novo advogado';
        $this->load->view('Administrador/novoAdvogado',$dados);
    }

    public function AlterarAdvogado($codAdvogado){
        $registros = $this->advogado_model->selectAdvogado($codAdvogado);
        $dados['registros'] = $registros[0];

        if ($this->validaCamposAdvogado() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            
            
            $sucesso        = $this->advogado_model->alterarAdvogado($dadosPost);

            if ($sucesso){
                redirect('Admin/Advogado','refresh');
            }
        }
        
        $dados['tituloGuia'] = 'Alterar advogado';
        $this->load->view('Administrador/alterarAdvogado',$dados); 
    } 

    private function validaCamposAdvogado(){      
        $this->form_validation->set_rules('nome_advogado', 'Nome advogado', 'trim|required');
           

        if ($this->form_validation->run() == false){
            return false;
        }
        return true;
    }

    //Foro
    public function Foro(){
        $dados['tituloGuia'] = 'Cadastro foro';
        $dados['registros'] = $this->foro_model->selectForo();
        $this->load->view('Administrador/cadastroForo',$dados);
    }

    public function novoForo(){
        if ($this->validaCamposForo() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            $sucesso        = $this->foro_model->cadastrarForo($dadosPost);

            if ($sucesso > 0){
                redirect('Admin/Foro','refresh');
            }
        }

        $dados['tituloGuia'] = 'Novo foro';
        $this->load->view('Administrador/novoForo',$dados);
    }

    public function AlterarForo($codigo){
        $registros = $this->foro_model->selectForo($codigo);
        $dados['registros'] = $registros[0];

        if ($this->validaCamposForo() == false){
            $dados['validacaoForm'] = validation_errors();
        }
        else{//passou na validacao
            $dadosPost      = $this->input->post();//recebe os valores do post
            $dadosPost      = $this->corrigirCamposBD($dadosPost);
            
            
            $sucesso        = $this->foro_model->alterarForo($dadosPost);

            if ($sucesso){
                redirect('Admin/Foro','refresh');
            }
        }
        
        $dados['tituloGuia'] = 'Alterar foro';
        $this->load->view('Administrador/alterarForo',$dados); 
    } 

    private function validaCamposForo(){      
        $this->form_validation->set_rules('nome_foro', 'Nome foro', 'trim|required');
           

        if ($this->form_validation->run() == false){
            return false;
        }
        return true;
    }

    private function corrigirCamposBD($array){
        //adiciona o campo data_criado no array
        $array['data_criado'] = date('Y-m-d H:i:s');

        //remove itens indesejados o do array que vai pro bd
        unset($array['enviar']);
        
        return $array;
    }   

    public function Login(){
        $this->form_validation->set_rules('codAdmin', 'código do administrador', 'trim|required');
        if ($this->form_validation->run() == FALSE){
            if (validation_errors()){
                set_msg(validation_errors());
            }
        }
        else{
            $dados_form = $this->input->post();
            $this->session->set_userdata('logado', True); //coloca na session de logado como admin
            set_msg('<p>Validação OK</p>');
            
            
            if ($dados_form['codAdmin'] == '180507fe'): //se foi a senha correta entra no admin
                redirect('AdminCtr/','refresh');
            else:
                set_msg('<p>Usuário incorreto</p>');
            endif;
        } 
        $dados['tituloGuia'] = 'Login Admin';
        $this->load->view('Administrador/login',$dados);    
    }

    public function TipoProcesso(){
        $dados['tituloGuia'] = 'Tipo processo';
        $this->load->view('Administrador/cadastroTipoProcesso',$dados);  
    }

    public function NovoTipoProcesso(){
        $dados['tituloGuia'] = 'Novo Tipo processo';
        $this->load->view('Administrador/novoTipoProcesso',$dados);  
    }

    public function AlterarTipoProcesso(){
        $dados['tituloGuia'] = 'Alterar Tipo processo';
        $this->load->view('Administrador/novoTipoProcesso',$dados);  
    }

    public function TipoAcao(){
        $dados['tituloGuia'] = 'Tipo ação';
        $this->load->view('Administrador/cadastroTipoAcao',$dados);  
    }

    public function NovoTipoAcao(){
        $dados['tituloGuia'] = 'Novo Tipo ação';
        $this->load->view('Administrador/novoTipoAcao',$dados);  
    }

    public function AlterarTipoAcao(){
        $dados['tituloGuia'] = 'Alterar Tipo ação';
        $this->load->view('Administrador/novoTipoAcao',$dados);  
    }

    public function FormaPagamento(){
        $dados['tituloGuia'] = 'Forma pagamento';
        $this->load->view('Administrador/cadastroFormaPagamento',$dados);  
    }

    public function NovoFormaPagamento(){
        $dados['tituloGuia'] = 'Novo Forma pagamento';
        $this->load->view('Administrador/novoFormaPagamento',$dados);  
    }

    public function AlterarFormaPagamento(){
        $dados['tituloGuia'] = 'Alterar Forma pagamento';
        $this->load->view('Administrador/novoFormaPagamento',$dados);  
    }
}
?>
