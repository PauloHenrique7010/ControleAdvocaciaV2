<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ProcessoMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectProcesso($codigo){
        $this->db->where('cod_processo',$codigo);
        return $this->db->get('processo')->result();
    }

    public function excluirProcesso($codigo){
        $this->db->where('cod_processo', $codigo);
        return $this->db->delete('processo');
    }

    public function cadastrarProcesso($array){
        $this->db->insert('processo',$array);
        return $this->db->insert_id();
    }

    public function editarProcesso($cod_processo, $array){
        $this->db->set($array);
        $this->db->where('cod_processo',$cod_processo);        
        if($this->db->update('processo')){
            return true;
        }
        return false;
    }
}
?>
