<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfissaoMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectProfissao($codProfissao = 0){
        if ($codProfissao > 0){
            $this->db->where('cod_profissao',$codProfissao);
        }
        return $this->db->get('profissoes')->result();
    }

    public function cadastrarProfissao($array){
        $this->db->insert('profissoes',$array);
        return $this->db->insert_id();
    }

    public function alterarProfissao($dados){
        $this->db->set($dados);
        $this->db->where('cod_profissao',$dados['cod_profissao']);        
        if($this->db->update('profissoes')){
            return true;
        }
        return false;
    }

    public function excluirProfissao($codProfissao){
        $this->db->where('cod_profissao', $codProfissao);
        return $this->db->delete('profissoes');
    }
}
?>
