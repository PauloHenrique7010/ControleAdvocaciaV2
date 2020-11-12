<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class OrgaoClasseMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectOrgaoClasse($codOrgaoClasse = 0){
        if ($codOrgaoClasse > 0){
            $this->db->where('cod_orgao_classe',$codOrgaoClasse);
        }
        return $this->db->get('orgao_classe')->result();
    }

    public function cadastrarOrgaoClasse($array){
        $this->db->insert('orgao_classe',$array);
        return $this->db->insert_id();
    }

    public function alterarOrgaoClasse($dados){
        $this->db->set($dados);
        $this->db->where('cod_orgao_classe',$dados['cod_orgao_classe']);        
        if($this->db->update('orgao_classe')){
            return true;
        }
        return false;
    }

    public function excluirOrgaoClasse($codOrgaoClasse){
        $this->db->where('cod_orgao_classe', $codOrgaoClasse);
        return $this->db->delete('orgao_classe');
    }
}
?>
