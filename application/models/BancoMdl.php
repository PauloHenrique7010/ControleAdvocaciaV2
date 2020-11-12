<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class BancoMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectBancoAjax(){
        $json = array(
            'type' => 'success',
            'message' => $this->db->get('banco')->result()
        );
        //header('Content-Type: application/json');
        //echo json_encode($json);
        return $json;
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
    

    public function cadastrarBanco(){
        $json = array();
        $this->form_validation->set_rules('nome_banco', 'Nome do banco', 'required');
        $this->form_validation->set_rules('codigo_banco', 'Código do banco', 'required');
        if($this->form_validation->run()){
            $dados = $this->input->post();
           // $this->nome_banco   = $this->input->post('nome_banco'); // please read the below note
            //$this->codigo_banco = $this->input->post('codigo_banco');
            $res = $this->db->insert('banco', $dados);
            if($res){
                $insert_id = $this->db->insert_id(); 
                $json = array(
                        'type' => 'success',
                        'message' => $this->db->get_where('banco', ['cod_banco' => $insert_id])->row_array()
                );
            } else {
                $json = array(
                        'type' => 'error',
                        'message' => 'Desculpe! Não foi possível cadastrar'
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

        /*$this->db->insert('banco',$array);
        if ($this->db->insert_id() > 0){
            return "OK";
        }*/
    }

    public function editarbanco($cod_banco, $dadosbanco){
        $this->db->set($dadosbanco);
        $this->db->where('cod_banco',$cod_banco);        
        if($this->db->update('banco')){
            return "OK";
        }
    }
}
?>
