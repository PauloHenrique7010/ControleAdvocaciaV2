<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    

    public function selectBanco($cod_banco=0){
        if ($cod_banco > 0){
            $this->db->where('cod_banco',$cod_banco);
        }
        return $this->db->get('banco')->result();
    }

    public function excluirBanco(){
        $json = array();
        $id = $this->input->post('cod_banco');
        if($id > 0){
            $res = $this->db->delete('banco', ['cod_banco' => $id]);
            if($res != FALSE){
                $json = array(
                    'type' => 'success',
                    'message' => 'Registro excluído com sucesso!'
                );   
            } else {
                $json = array(
                    'type' => 'error',
                    'message' => 'Desculpe! Não foi possível excluir'
                );                                  
            }    
        } else{
            $json = array(
                'type' => 'error',
                'message' => 'Invalid ID'
            );   
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function alterarBanco(){
        $json = array();
        $this->form_validation->set_rules('cod_banco', 'ID', 'required');
        $this->form_validation->set_rules('codigo_banco', 'Código do banco', 'required');
        $this->form_validation->set_rules('nome_banco', 'Nome do banco', 'required');
        if($this->form_validation->run()){
            $id                     = $this->input->post('cod_banco');
            $data['codigo_banco']   = $this->input->post('codigo_banco');
            $data['nome_banco']     = $this->input->post('nome_banco');
            $update_id = $this->db->update('banco', $data, array('cod_banco' => $id));
            if($update_id){
                $json = array(
                        'type' => 'success',
                        'message' => $this->db->get_where('banco', ['cod_banco' => $id])->row_array()
                );
            } else {
                $json = array(
                        'type' => 'error',
                        'message' => 'Desculpe! Não foi possível alterar'
                );
            }
        } else{
            $json = array(
                    'type' => 'error',
                    'message' => validation_errors()
            );
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    

    public function cadastrarForo(){
        $json = array();
        $dados = $this->input->post();
        $res = $this->db->insert('foros', $dados);
        if($res){
            $insert_id = $this->db->insert_id(); 
            $json = array(
                    'type' => 'success',
                    'message' => $this->db->get_where('foros', ['cod_foro' => $insert_id])->row_array()
            );
        } else {
            $json = array(
                    'type' => 'error',
                    'message' => 'Desculpe! Não foi possível cadastrar'
            );
        }
        

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    

    public function editarbanco($cod_banco, $dadosbanco){
        $this->db->set($dadosbanco);
        $this->db->where('cod_banco',$cod_banco);        
        if($this->db->update('banco')){
            return "OK";
        }
    }


    public function excluirProfissao($codProfissao = 0){
        $json = array();
        
        $res = $this->db->delete('profissoes', ['cod_profissao' => $codProfissao]);
        if($res != FALSE){
            $json = array(
                'type' => 'success',
                'message' => 'Registro excluído com sucesso!'
            );   
        } else {
            $json = array(
                'type' => 'error',
                'message' => 'Desculpe! Não foi possível excluir'
            );                                  
        }    
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public function excluirOrgaoClasse($codOrgaoClasse = 0){
        $json = array();
        
        $res = $this->db->delete('orgao_classe', ['cod_orgao_classe' => $codOrgaoClasse]);
        if($res != FALSE){
            $json = array(
                'type' => 'success',
                'message' => 'Registro excluído com sucesso!'
            );   
        } else {
            $json = array(
                'type' => 'error',
                'message' => 'Desculpe! Não foi possível excluir'
            );                                  
        }    
        header('Content-Type: application/json');
        echo json_encode($json);

    }

    public function excluirEstadoCivil($codEstadoCivil = 0){
        $json = array();
        
        $res = $this->db->delete('estado_civil', ['cod_estado_civil' => $codEstadoCivil]);
        if($res != FALSE){
            $json = array(
                'type' => 'success',
                'title' => '',
                'message' => 'Registro excluído com sucesso!'
            );   
        } else {
            $json = array(
                'type' => 'error',
                'title' => 'Erro!',
                'message' => 'Desculpe! Não foi possível excluir'
            );                                  
        }    
        return $json;
    }

    public function excluirAdvogado($codAdvogado = 0){
        $json = array();
        
        $res = $this->db->delete('advogado', ['cod_advogado' => $codAdvogado]);
        if($res != FALSE){
            $json = array(
                'type' => 'success',
                'title' => '',
                'message' => 'Registro excluído com sucesso!'
            );   
        } else {
            $json = array(
                'type' => 'error',
                'title' => 'Erro!',
                'message' => 'Desculpe! Não foi possível excluir'
            );                                  
        }    
        return $json;
    }

    public function excluirForo($codigo = 0){
        $json = array();
        
        $res = $this->db->delete('foros', ['cod_foro' => $codigo]);
        if($res != FALSE){
            $json = array(
                'type' => 'success',
                'title' => '',
                'message' => 'Registro excluído com sucesso!'
            );   
        } else {
            $json = array(
                'type' => 'error',
                'title' => 'Erro!',
                'message' => 'Desculpe! Não foi possível excluir'
            );                                  
        }    
        return $json;
    }
}
?>
