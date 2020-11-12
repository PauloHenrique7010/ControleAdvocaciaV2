<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ForoMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectForo($codForo = 0){
        if ($codForo > 0){
            $this->db->where('cod_foro',$codForo);
        }
        return $this->db->get('foros')->result();
    }

    public function cadastrarForo($array){
        $this->db->insert('foros',$array);
        return $this->db->insert_id();
    }

    public function alterarForo($dados){
        $this->db->set($dados);
        $this->db->where('cod_foro',$dados['cod_foro']);        
        if($this->db->update('foros')){
            return true;
        }
        return false;
    }

    public function excluirForo($codForo){
        $this->db->where('cod_foro', $codForo);
        return $this->db->delete('foros');
    }
}
?>
