<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AdvogadoMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectAdvogado($codAdvogado = 0){
        if ($codAdvogado > 0){
            $this->db->where('cod_advogado',$codAdvogado);
        }
        return $this->db->get('advogado')->result();
    }

    public function cadastrarAdvogado($array){
        $this->db->insert('advogado',$array);
        return $this->db->insert_id();
    }

    public function alterarAdvogado($dados){
        $this->db->set($dados);
        $this->db->where('cod_advogado',$dados['cod_advogado']);        
        if($this->db->update('advogado')){
            return true;
        }
        return false;
    }

    public function excluirAdvogado($codAdvogado){
        $this->db->where('cod_advogado', $codAdvogado);
        return $this->db->delete('advogado');
    }
}
?>
